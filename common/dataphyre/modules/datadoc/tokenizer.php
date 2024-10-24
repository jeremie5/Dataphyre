<?php
/*************************************************************************
*  Shopiro Ltd.
*  All Rights Reserved.
* 
* NOTICE:  All information contained herein is, and remains the 
* property of Shopiro Ltd. and its suppliers, if any. The 
* intellectual and technical concepts contained herein are 
* proprietary to Shopiro Ltd. and its suppliers and may be 
* covered by Canadian and Foreign Patents, patents in process, and 
* are protected by trade secret or copyright law. Dissemination of 
* this information or reproduction of this material is strictly 
* forbidden unless prior written permission is obtained from Shopiro Ltd..
*/

namespace dataphyre\datadoc;

class tokenizer{

	public static function tokenize($filename){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!file_exists($filename)){
			return false;
		}
		$tokens = [];
		$current_namespace = null;
		$current_class = null;
		$current_function = null;
		$current_variable = null;
		$inside_phpdoc = false;
		$current_phpdoc = '';
		$current_line = 0;
		$namespace_counter = 0;
		$class_counter = 0;
		$function_counter = 0;
		$namespace_content = '';
		$class_content = '';
		$function_content = '';
		$file = fopen($filename, "r");
		if ($file) {
			$namespace_counter = $class_counter = $function_counter = 0;
			$namespace_content = $class_content = $function_content = '';
			$inside_script = false;
			while (($line = fgets($file)) !== false) {
				// Check for <script> start tag
				if (preg_match('/<script[^>]*>/i', $trimmed_line)) {
					$inside_script = true;
				}
				// Check for </script> end tag
				if (preg_match('/<\/script>/i', $trimmed_line)) {
					$inside_script = false;
				}
				// Skip tokenization if inside <script> block
				if ($inside_script) {
					continue;
				}
				$current_line++;
				$trimmed_line = trim($line);
				// Append lines to the content
				if ($namespace_counter > 0) $namespace_content .= $line;
				if ($class_counter > 0) $class_content .= $line;
				if ($function_counter > 0) $function_content .= $line;
				// Update counters
				$openBraces = substr_count($line, '{');
				$closeBraces = substr_count($line, '}');
				if ($namespace_counter > 0) $namespace_counter += ($openBraces - $closeBraces);
				if ($class_counter > 0) $class_counter += ($openBraces - $closeBraces);
				if ($function_counter > 0) $function_counter += ($openBraces - $closeBraces);
				// Parsing PHPDoc
				if (strpos($trimmed_line, '/**') !== false) {
					$inside_phpdoc = true;
					$temp_phpdoc_string = '';  // Reset temp_phpdoc_string
				}
				if ($inside_phpdoc) {
					$temp_phpdoc_string .= $trimmed_line . "\n";
				}
				if (strpos($trimmed_line, '*/') !== false) {
					$inside_phpdoc = false;
					$tags = [];  // Associative array to keep track of tags and their comments
					$current_type = "";  // Keep track of the last annotation type encountered
					$description = "";  // Store initial description text, before any tags
					$lines = explode("\n", $temp_phpdoc_string);
					foreach ($lines as $phpdoc_line) {
						if (preg_match('/@(\w+)\s*(.*)/', $phpdoc_line, $matches)) {
							$current_type = $matches[1];
							$tags[$current_type] = $matches[2] . "\n";
							continue;
						}
						if (!empty($current_type)) {
							if (!preg_match('/^@/', $phpdoc_line)) {
								$tags[$current_type] .= trim(str_replace('*', '', $phpdoc_line)) . "\n";
								continue;
							}
							else
							{
								$current_type = "";  // Reset type
							}
						}
						$comment_line = trim(str_replace(['/**', '*/', '*'], '', $phpdoc_line));
						if (empty($current_type) && !empty($comment_line)) {
							$description .= $comment_line . "\n";
						}
					}
					$current_phpdoc = ['description' => $description, 'tags' => $tags];
				}
				if (preg_match('/^namespace\s+([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*(?:\\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)*)/', $trimmed_line, $matches)) {
					$current_namespace = $matches[1];
					$tokens[] = [
						'type' => 'namespace',
						'namespace' => $current_namespace,
						'content'=>$namespace_content,
						'line' => $current_line,
						'phpdoc' => $current_phpdoc
					];
					$current_phpdoc = '';
				}
				if (preg_match('/^class\s+([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $trimmed_line, $matches)) {
					$current_class = $matches[1];
					$tokens[] = [
						'type' => 'class',
						'class' => $current_class,
						'content'=>$class_content,
						'namespace' => $current_namespace,
						'line' => $current_line,
						'phpdoc' => $current_phpdoc
					];
					$current_phpdoc = '';
				}
				if (preg_match('/^(public|private|protected)?\s*(static)?\s*function\s+([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $trimmed_line, $matches)) {
					$current_function = $matches[3];
					$tokens[] = [
						'type' => 'function',
						'content'=>$function_content,
						'function' => $current_function,
						'namespace' => $current_namespace,
						'class' => $current_class,
						'line' => $current_line,
						'phpdoc' => $current_phpdoc
					];
					$current_phpdoc = '';
				}
				if (preg_match('/^\s*(public|private|protected)?\s*(static)?\s*\$([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $trimmed_line, $matches)) {
					$current_variable = $matches[3];
					$tokens[] = [
						'type' => 'variable',
						'content' => $current_variable,
						'namespace' => $current_namespace,
						'class' => $current_class,
						'function' => $current_function,
						'line' => $current_line,
						'phpdoc' => $current_phpdoc
					];
					$current_phpdoc = '';
				}
				if(preg_match('/tracelog\((.*)\)/', $trimmed_line, $matches)){
					if(!str_contains($matches[1], "function_call")){
						$tokens[]=['type'=>'tracelog', 'content'=>$matches[1], 'namespace'=>$current_namespace, 'class'=>$current_class, 'function'=>$current_function, 'line'=>$current_line];
					}
				}
				if (preg_match('/^(public|private|protected)?\s*(static)?\s*function\s+([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/', $trimmed_line, $matches)) {
					$current_function = $matches[3];
					$function_counter = 1;
					$function_content = $line;  // Initialize function content with the line where the function is declared
				}
				else {
					// Check for function end
					if ($function_counter == 0 && !empty($function_content)) {
						$last_function_key = array_key_last(array_filter($tokens, function($token) {
							return $token['type'] === 'function';
						}));
						if($last_function_key !== null) {
							$tokens[$last_function_key]['content'] = $function_content;
						}
						$function_content = '';
					}
				}
				// Check for function end
				if ($function_counter == 0 && !empty($function_content)) {
					$last_function_key = array_key_last(array_filter($tokens, function($token) {
						return $token['type'] === 'function';
					}));
					if($last_function_key !== null) {
						$tokens[$last_function_key]['content'] = $function_content;
					}
					$function_content = '';
				}
				// When a new block is declared, reset the counter and the content string for that block
				if (preg_match('/^namespace\s+/', $trimmed_line)) {
					$namespace_counter = 1;
					$namespace_content = $line;
				}
				if (preg_match('/^class\s+/', $trimmed_line)) {
					$class_counter = 1;
					$class_content = $line;
				}
				if (preg_match('/^(public|private|protected)?\s*(static)?\s*function\s+/', $trimmed_line)) {
					$function_counter = 1;
					$function_content = $line;
				}
			}
			fclose($file);
		}
		else
		{
			return false;
		}
		return $tokens;
	}
	
}