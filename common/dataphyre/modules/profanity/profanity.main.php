<?php
/*************************************************************************
*  2020-2022 Shopiro Ltd.
*  All Rights Reserved.
* 
* NOTICE:  All information contained herein is, and remains the
* property of Shopiro Ltd. and its suppliers, if any. The
* intellectual and technical concepts contained herein are
* proprietary to Shopiro Ltd. and its suppliers and may be
* covered by Canadian and Foreign Patents, patents in process, and
* are protected by trade secret or copyright law. Dissemination of
* this information or reproduction of this material is strictly
* forbidden unless prior written permission is obtained from Shopiro Ltd.
*/

namespace dataphyre;

tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T="Loaded");

dp_module_required('profanity', 'fulltext_engine');

// Dysphemistic swearing gives a negative input either to the subject matter or to the audience, or both. (This tastes/you look like shit!)
// Abusive swearing is used to abuse, intimidate or insult others (Fuck you!/You son of a bitch!)
// Idiomatic swearing is using the words to grab attention and assert coolness, or express to peers that the setting is informal. (Fuck, man./Hell, yeah.)
// Emphatic swearing is emphasing something with swearing. (It was funny as shit/This tastes fucking great!)
// Cathartic swearing is used when something bad happens, like getting hurt, dropping stuff or feeling bad. Theory: you tell the audience that you're undergoing a negative emotion. (Aww, fuck!/Damn this coffee)

class profanity{

    private $fulltext_engine;
	
    public function __construct(){
        $this->fulltext_engine=new fulltext_engine();
    }
	
	public function evaluate(string $string, string $ruleset, string $language='en'){
		global $rootpath;
		global $cached_profanity_rulesets;
		if(str_contains($language, "-")){
			if(!in_array($language, array("mni-Mtei", "zh-CN", "zh-TW"))){
				$language=explode('-', $language)[0];
			}
		}
		if(file_exists($ruleset_file=__DIR__."/datasets/".$language."/".$ruleset.".php")){ 
			require_once($ruleset_file);
			if(!empty($cached_profanity_rulesets[$ruleset])){
				$unscrubbed=$this->unscrub($string, array($language));
				return $this->verify($unscrubbed['unscrubbed'], $cached_profanity_rulesets[$ruleset], $language);
			}
		}
		return false;
	}
	
	public function unscrub(string $string, array $languages=array('en')){
		global $rootpath;
		global $cached_unscrub_rulesets;
		$languages=array_unique($languages);
		foreach($languages as $language){
			if(str_contains($language, "-")){
				if(!in_array($language, array("mni-Mtei", "zh-CN", "zh-TW"))){
					$language=explode('-', $language)[0];
				}
			}
			if(file_exists($ruleset_file=__DIR__."/unscrubbers/".$language.".php")){
				require_once($ruleset_file);
				if(!empty($cached_unscrub_rulesets[$language])){
					$domain_cctlds=array("com","org","net","int","edu","gov","mil","eu","ca","us", "fr", "be", "nz", "info");
					$matches=[];
					$original=$string;
					foreach($cached_unscrub_rulesets[$language] as $rule=>$parameters){
						if($rule==='sequential_chars_split'){
							foreach($parameters as $param){
								$string=preg_replace_callback($param['pattern'], function($matches) use ($param){
									return str_replace($param['replace'], $param['replacement'], $matches[0]);
								}, $string, -1, $count);
								if($count>0){
									$matches[]=$rule;
								}
							}
						}
						elseif($rule==='domain_disguised'){
							foreach($parameters as $param){
								$string=preg_replace_callback($param['pattern'], function($matches) use ($param,$domain_cctlds){
									if(in_array($matches[3], $domain_cctlds)){
										return str_replace($param['replace'], $param['replacement'], $matches[0]);
									}
									return $matches[0];
								}, $string, -1, $count);
								if($count>0){
									$matches[]=$rule;
								}
							}
						}
						elseif($rule==='email_disguised'){
							foreach($parameters as $param){
								$string=preg_replace_callback($param['pattern'], function($matches) use ($param, $domain_cctlds){
									$domainParts=explode(' ', $matches[2]);
									if(in_array(end($domainParts), $domain_cctlds)){
										$email=$param['replacement'][0].str_replace($param['replace'], $param['replacement'][1], $matches[2]);
										return $matches[1].$email;
									}
									return $matches[0];
								}, $string, -1, $count);
								if($count>0){
									$matches[]=$rule;
								}
							}
						}
						elseif($rule==='deceptive_characters'){
							foreach($parameters['map'] as $deceptiveChar=>$replacement){
								$count=0;
								$string=str_replace($deceptiveChar, $replacement, $string, $count);
								if($count>0){
									$matches[]=$rule;
								}
							}
						}
					}
				}
			}
		}
		return[
			'unscrubbed'=>$string, 
			'original'=>$original, 
			'matches'=>array_unique($matches)
		];
	}

	public function verify(string $string, array $rules, string $language='en'){
		if(!empty($rules)){
			$index_name=$rules['ruleset_type'].'_'.$language;
			$rules=$rules['rules'];
			if(true===$this->fulltext_engine->create_index($index_name, "marker")){
				foreach($rules as $word=>$rule){
					$this->fulltext_engine->add_to_index($index_name, ["marker"=>$word, "value"=>$word], $language);
				}
			}
			$matches=[];
			$totalScore=0;
			$string=strtolower($string);
			$string=str_replace(',', '', $string);
			$stringWords=explode(' ', $string);
			foreach($stringWords as $wordIndex=>$word){
				$fullstringResults=$this->fulltext_engine->find_in_index($index_name, ["value"=>$word], $language, $boolean_mode=false, $max_results=25, $threshold=0.85, $forced_algorithms='damerau_lavenshtein');
				$fullstring_results_reindexed=[];
				foreach($fullstringResults as $key=>$result){
					foreach($result as $word=>$score){
						$fullstring_results_reindexed[$word]=$score;
					}
				}
				if(isset($fullstring_results_reindexed[$word])){
					$rule=$rules[$word];
					$followingWord=$stringWords[$wordIndex+1] ?? null;
					$precedingWord=$stringWords[$wordIndex-1] ?? null;
					if(isset($rule['base_weight'])){
						$matches[]=$word;
						$totalScore+=$rule['base_weight'];
					}
					if(isset($rule['anywhere'])){
						foreach($rule['anywhere']['words'] as $followWord){
							if(in_array($followWord, $stringWords)){
								$matches[]=$word;
								$totalScore+=$rule['anywhere']['weight'];
								break;
							}
						}
					}
					if(isset($rule['not_immediately_followed_by']) && $followingWord && !in_array($followingWord, $rule['not_immediately_followed_by']['words'])){
						$matches[]=$word;
						$totalScore+=$rule['not_immediately_followed_by']['weight'];
					}
					if(isset($rule['immediately_followed_by']) && $precedingWord && in_array($precedingWord, $rule['immediately_followed_by']['words'])){
						$matches[]=$word;
						$totalScore+=$rule['immediately_followed_by']['weight'];
					}
					if(isset($rule['not_immediately_preceeded_by']) && $precedingWord && !in_array($precedingWord, $rule['not_immediately_preceeded_by']['words'])){
						$matches[]=$word;
						$totalScore+=$rule['not_immediately_preceeded_by']['weight'];
					}
					if(isset($rule['immediately_preceeded_by']) && $precedingWord && in_array($precedingWord, $rule['immediately_preceeded_by']['words'])){
						$matches[]=$word;
						$totalScore+=$rule['immediately_preceeded_by']['weight'];
					}
					if(isset($rule['followed_by'])){
						foreach($rule['followed_by']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(in_array($modifier_word, array_slice($stringWords, $wordIndex+1))){
									$matches[]=$word;
									$totalScore+=$rule['followed_by']['weight'];
								}
							}
						}
					}
					if(isset($rule['not_followed_by'])){
						foreach($rule['not_followed_by']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(!in_array($modifier_word, array_slice($stringWords, $wordIndex+1))){
									$matches[]=$word;
									$totalScore+=$rule['not_followed_by']['weight'];
								}
							}
						}
					}
					if(isset($rule['preceeded_by'])){
						foreach($rule['preceeded_by']['words'] as $modifier_word){
							if(in_array($modifier_word, array_slice($stringWords, $wordIndex+1))){
								if(!empty($modifier_word)){
									$matches[]=$word;
									$totalScore+=$rule['preceeded_by']['weight'];
								}
							}
						}
					}
					if(isset($rule['not_preceeded_by'])){
						foreach($rule['not_preceeded_by']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(!in_array($modifier_word, array_slice($stringWords, $wordIndex+1))){
									$matches[]=$word;
									$totalScore+=$rule['not_preceeded_by']['weight'];
								}
							}
						}
					}
					if(isset($rule['followed_by_in_sentence'])){
						$sentenceEnd=strpos($string, ".", $wordIndex);
						$sentence=$sentenceEnd!==false ? substr($string, $wordIndex, $sentenceEnd-$wordIndex):$string;
						foreach($rule['followed_by_in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)!==false){
									$matches[]=$word;
									$totalScore+=$rule['followed_by_in_sentence']['weight'];
									break;
								}
							}
						}
					}
					if(isset($rule['not_followed_by_in_sentence'])){
						$sentenceEnd=strpos($string, ".", $wordIndex);
						$sentence=$sentenceEnd!==false ? substr($string, $wordIndex, $sentenceEnd-$wordIndex):$string;
						foreach($rule['not_followed_by_in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)===false){
									$matches[]=$word;
									$totalScore+=$rule['not_followed_by_in_sentence']['weight'];
								}
							}
						}
					}
					if(isset($rule['preceeded_by_in_sentence'])){
						$stringBeforeWord=substr($string, 0, strpos($string, $word));
						$sentenceStart=strrpos($stringBeforeWord, ".");
						$sentence=$sentenceStart!==false ? substr($stringBeforeWord, $sentenceStart+1):$stringBeforeWord;
						foreach($rule['preceeded_by_in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)!==false){
									$matches[]=$word;
									$totalScore+=$rule['preceeded_by_in_sentence']['weight'];
								}
							}
						}
					}
					if(isset($rule['not_preceeded_by_in_sentence'])){
						$stringBeforeWord=substr($string, 0, strpos($string, $word));
						$sentenceStart=strrpos($stringBeforeWord, ".");
						$sentence=$sentenceStart!==false ? substr($stringBeforeWord, $sentenceStart+1):$stringBeforeWord;
						foreach($rule['not_preceeded_by_in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)===false){
									$matches[]=$word;
									$totalScore+=$rule['not_preceeded_by_in_sentence']['weight'];
								}
							}
						}
					}
					if(isset($rule['in_sentence'])){
						$sentenceEnd=strpos($string, ".", $wordIndex);
						$sentence=$sentenceEnd!==false?substr($string, $wordIndex, $sentenceEnd-$wordIndex):$string;
						foreach($rule['in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)===true){
									$matches[]=$word;
									$totalScore+=$rule['in_sentence']['weight'];
								}
							}
						}
					}
					if(isset($rule['not_in_sentence'])){
						$sentenceEnd=strpos($string, ".", $wordIndex);
						$sentence=$sentenceEnd!==false?substr($string, $wordIndex, $sentenceEnd-$wordIndex):$string;
						foreach($rule['not_in_sentence']['words'] as $modifier_word){
							if(!empty($modifier_word)){
								if(str_contains($sentence, $modifier_word)===false){
									$matches[]=$word;
									$totalScore+=$rule['not_in_sentence']['weight'];
								}
							}
						}
					}
				}
			}
			$maxScore=0;
			$minScore=0;
			if(!empty($rules)){
				foreach($matches as $word){
					$rule=$rules[$word];
					if(isset($rule['base_weight'])){
						if($rule['base_weight']>0){
							$maxScore+=$rule['base_weight'];
						}
						else
						{
							$minScore+=$rule['base_weight'];
						}
					}
					foreach($rule as $key=>$value){
						if(is_array($value) && array_key_exists('weight', $value)){
							if($value['weight']>0){
								$maxScore+=$value['weight'];
							}
							else
							{
								$minScore+=$value['weight'];
							}
						}
					}
				}
			}
			$scoreRange=$maxScore-$minScore;
			$normalizedScore=$scoreRange!==0?(($totalScore-$minScore)/$scoreRange):0;
			return [
				'matches'=>array_unique($matches), 
				'score'=>$normalizedScore
			];
		}
		return [
			'matches'=>[], 
			'score'=>0
		];
	}
}