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


$cached_profanity_rulesets['csam']=[
    "ruleset_type"=>"csam",
    "rules"=>[
        "porn"=>[
            "base_weight"=>-1,
            "in_sentence"=>[
                "weight"=>+1,
                "words"=>["underage", "under age", "explicit", "child", "children", "kid", "son", "daughter"]
            ],
            "not_in_sentence"=>[
                "weight"=>-4,
                "words"=>["18", "18+", "mature", "adult", "step"]
            ],
        ],
        "sex"=>[
            "base_weight"=>1,
            "in_sentence"=>[
                "weight"=>+3,
                "words"=>["underage", "under age", "explicit", "child", "children", "kid", "son", "daughter"]
            ],
            "not_in_sentence"=>[
                "weight"=>-4,
                "words"=>["18", "18+", "mature", "adult", "step"]
            ],
        ],
    ],
];