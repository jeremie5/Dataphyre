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