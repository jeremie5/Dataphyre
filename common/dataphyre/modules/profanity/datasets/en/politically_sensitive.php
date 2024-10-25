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


$cached_profanity_rulesets['politically_sensitive']=[
    "ruleset_type" => "politically_sensitive",
    "rules" => [
        "politics" => [
            "base_weight" => +1,
            "anywhere" => [
                "weight" => +1,
                "words" => ["government", "election"]
            ],
            "in_sentence" => [
                "weight" => +2,
                "words" => ["policy", "parties"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["democracy", "leaders"]
            ],
        ],
        "campaign" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["candidates", "voters"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["rally", "election"]
            ],
        ],
        "legislation" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["laws", "bills"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["enact", "amend"]
            ],
        ],
        "governance" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["administration", "policies"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["leadership", "decision-making"]
            ],
        ],
        "political party" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["platform", "members"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["affiliation", "campaign"]
            ],
        ],
        "ideology" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["beliefs", "principles"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["policies", "movement"]
            ],
        ],
        "government" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["administration", "public"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["officials", "policy"]
            ],
        ],
        "democracy" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["citizens", "voting"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["freedom", "rights"]
            ],
        ],
        "political system" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["governance", "structure"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["constitution", "election"]
            ],
        ],
        "activism" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["protest", "advocacy"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["social change", "campaign"]
            ],
        ],
        "political debate" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["arguments", "perspectives"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["opinions", "policy"]
            ],
        ],
		"political stability" => [
			"base_weight" => +1,
			"in_sentence" => [
				"weight" => +2,
				"words" => ["peace", "order"]
			],
			"followed_by" => [
				"weight" => +1,
				"words" => ["governance", "development"]
			],
		],
        "election" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["voting", "candidates"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["campaign", "results"]
            ],
        ],
        "public office" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["position", "responsibilities"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["leadership", "service"]
            ],
        ],
        "political speech" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["address", "rhetoric"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["audience", "message"]
            ],
        ],
        "government policy" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["regulation", "decision"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["implementation", "impact"]
            ],
        ],
        "political leader" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["statesman", "figure"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["influence", "legacy"]
            ],
        ],
    ],
];