<?php
 /*************************************************************************
 *  2020-2024 Shopiro Ltd.
 *  All Rights Reserved.
 * 
 * NOTICE: All information contained herein is, and remains the 
 * property of Shopiro Ltd. and is provided under a dual licensing model.
 * 
 * This software is available for personal use under the Free Personal Use License.
 * For commercial applications that generate revenue, a Commercial License must be 
 * obtained. See the LICENSE file for details.
 *
 * This software is provided "as is", without any warranty of any kind.
 */


$cached_profanity_rulesets['abusive_swearing']=[
	"ruleset_type"=>"abusive_swearing",
	"rules"=>[
		"fuck"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["you", "your"]
			],
			"immediately_followed_by"=>[
				"weight"=>-4,
				"words"=>["that", "sake"]
			],
		],
		"fucker"=>[
			"base_weight"=>+3,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["off", "you"]
			],
			"immediately_followed_by"=>[
				"weight"=>-2,
				"words"=>["sake", "around"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["at", "in"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["this", "that"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["little", "stupid"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you", "this"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["again", "never"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["always", "forever"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["happy", "glad"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you", "that"]
			],
		],
		"fucked"=>[
			"base_weight"=>+3,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["up", "over"]
			],
			"immediately_followed_by"=>[
				"weight"=>-1,
				"words"=>["up", "sake"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["again", "it"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["this", "that"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["just", "totally"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you", "I"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["again", "later"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["always", "never"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["sorry", "unfortunately"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you", "they"]
			],
		],
		"fucking"=>[
			"base_weight"=>+3,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["great", "awesome", "unbelievable", "ridiculous"]
			],
			"immediately_followed_by"=>[
				"weight"=>-2,
				"words"=>["idiot", "jerk"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["now", "later"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["always", "never"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["sorry", "please"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you're", "it's"]
			],
		],
		"shit"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["you", "your"]
			],
			"immediately_followed_by"=>[
				"weight"=>-3,
				"words"=>["that", "sake"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["it", "this"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["it", "this"]
			],
		],
		"shitty"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["weather", "mood"]
			],
			"immediately_followed_by"=>[
				"weight"=>-2,
				"words"=>["attitude", "behavior"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["again", "anymore"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["sometimes", "often"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["sorry", "unfortunately"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["it's", "that's"]
			],
		],
		"bitch"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+2,
				"words"=>["please", "but"]
			],
			"immediately_followed_by"=>[
				"weight"=>-3,
				"words"=>["slap", "fight"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["much", "more"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["time", "energy"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["not", "never"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["always", "often"]
			]
		],
		"damn"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "it"]
			],
			"immediately_followed_by"=>[
				"weight"=>-2,
				"words"=>["good", "fine"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["it", "this"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["it", "this"]
			],
		],
		"asshole"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "your"]
			],
			"immediately_followed_by"=>[
				"weight"=>-1,
				"words"=>["stop", "quit"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["stop", "no"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["go", "do"]
			],
		],
		"bastard"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "your"]
			],
			"immediately_followed_by"=>[
				"weight"=>-2,
				"words"=>["stop", "quit"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["stop", "no"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["go", "do"]
			],
		],
		"dick"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["head", "wad"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["you", "it"]
			],
		],
		"prick"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "off"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["go", "do"]
			],
		],
		"twat"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "off"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["go", "do"]
			],
		],
		"bellend"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "off"]
			],
		],
		"bastard"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "that"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["always", "never"]
			],
		],
		"tosser"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "he"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-3,
				"words"=>["not", "no"]
			],
		],
		"wanker"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["off", "you"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["can't", "won't"]
			],
		],
		"shithead"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["stop", "enough"]
			],
		],
		"bugger"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["off", "you"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["never", "always"]
			],
		],
		"prick"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "he", "she"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["sorry", "apologize"]
			],
		],
		"dickhead"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["off", "you"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["can't", "won't"]
			],
		],
		"bellend"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["stop", "enough"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["sorry", "apologize"]
			],
		],
		"bastard"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["can't", "won't"]
			],
		],
		"wanker"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["stop", "enough"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["sorry", "apologize"]
			],
		],
		"tosser"=>[
			"base_weight"=>+2,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["off", "you"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["never", "always"]
			],
		],
		"twat"=>[
			"base_weight"=>+2,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "he", "she"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["sorry", "apologize"]
			],
		],
		"numpty"=>[
			"base_weight"=>-1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["think", "believe"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["joke", "funny"]
			],
		],
		"muppet"=>[
			"base_weight"=>+1,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["can't", "won't"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["wise", "smart"]
			],
		],
		"lummox"=>[
			"base_weight"=>+1,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["slow", "stupid"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["quick", "fast"]
			],
		],
		"nincompoop"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["is", "was"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["intelligent", "clever"]
			],
		],
		"airhead"=>[
			"base_weight"=>+1,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["much", "such"]
			],
		],
		"blockhead"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["never", "not"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["smart", "bright"]
			],
		],
		"dunce"=>[
			"base_weight"=>+1,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["cap", "hat"]
			],
			"not_followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["smart", "genius", "bright"]
			],
		],
		"dweeb"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["is", "was"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["cool", "popular"]
			],
		],
		"numbskull"=>[
			"base_weight"=>+1,
			"immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["you", "he", "she"]
			],
		],
		"simpleton"=>[
			"base_weight"=>+1,
			"not_immediately_followed_by"=>[
				"weight"=>+1,
				"words"=>["never", "not"]
			],
			"followed_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["smart", "intelligent", "clever"]
			],
		],
		"moron"=>[
			"base_weight"=>+1,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
		"nitwit"=>[
			"base_weight"=>+1,
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["smart", "clever"]
			],
		],
		"peabrain"=>[
			"base_weight"=>+1,
			"preceeded_by"=>[
				"weight"=>+1,
				"words"=>["you", "he", "she"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
		"twit"=>[
			"base_weight"=>+1,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["never", "not"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["smart", "intelligent", "clever"]
			],
		],
		"dimwit"=>[
			"base_weight"=>+1,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["not", "never"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["clever", "smart"]
			],
		],
		"birdbrain"=>[
			"base_weight"=>+1,
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["complete", "utter"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
		"bonehead"=>[
			"base_weight"=>+1,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["not", "hardly"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["intelligent", "smart"]
			],
		],
		"fool"=>[
			"base_weight"=>+2,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["not", "never"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["wise", "smart"]
			],
		],
		"jerk"=>[
			"base_weight"=>+2,
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["such", "a", "big", "this"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
		"douchebag"=>[
			"base_weight"=>+3,
			"not_preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["not", "never"]
			],
			"preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["definitely", "not"]
			],
		],
		"asshat"=>[
			"base_weight"=>+3,
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["complete", "total"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
		"jackass"=>[
			"base_weight"=>+3,
			"preceeded_by_in_sentence"=>[
				"weight"=>+1,
				"words"=>["such", "a"]
			],
			"not_preceeded_by_in_sentence"=>[
				"weight"=>-1,
				"words"=>["not", "never"]
			],
		],
    ],
];