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

$cached_profanity_rulesets['self_harm']=[
    "ruleset_type"=>"self_harm",
    "rules"=>[
        "suicide"=>[
            "base_weight"=>+1,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["commit", "thinking"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>-3,
                "words"=>["not"]
            ],
        ],
        "self-harm" => [
            "base_weight" => 1,
            "followed_by_in_sentence" => [
                "weight" => 2,
                "words" => ["methods", "coping"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -3,
                "words" => ["help", "support"]
            ],
            "not_immediately_followed_by" => [
                "weight" => -2,
                "words" => ["is", "are", "am"]
            ]
        ],
        "cutting" => [
            "base_weight" => 1,
            "in_sentence" => [
                "weight" => 2,
                "words" => ["release", "control"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -3,
                "words" => ["therapist", "support"]
            ]
        ],
        "overdose" => [
            "base_weight" => 1,
            "in_sentence" => [
                "weight" => 2,
                "words" => ["pills", "medication"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -3,
                "words" => ["help", "support"]
            ]
        ],
        "hopeless" => [
            "base_weight" => 1,
            "in_sentence" => [
                "weight" => 2,
                "words" => ["future", "life"]
            ],
            "followed_by_in_sentence" => [
                "weight" => 1,
                "words" => ["is", "feels"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -2,
                "words" => ["hope", "optimistic"]
            ]
        ],
        "lonely" => [
            "base_weight" => 1,
            "in_sentence" => [
                "weight" => 2,
                "words" => ["isolated", "alone"]
            ],
            "followed_by_in_sentence" => [
                "weight" => 1,
                "words" => ["feels", "is"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -2,
                "words" => ["company", "friends"]
            ]
        ],
        "worthless" => [
            "base_weight" => 1,
            "in_sentence" => [
                "weight" => 2,
                "words" => ["useless", "meaningless"]
            ],
            "followed_by_in_sentence" => [
                "weight" => 1,
                "words" => ["feels", "is"]
            ],
            "not_followed_by_in_sentence" => [
                "weight" => -2,
                "words" => ["value", "self-worth"]
            ]
        ],
        "suicidal" => [
            "base_weight" => +1,
            "anywhere" => [
                "weight" => +1,
                "words" => ["end", "life"]
            ],
            "not_followed_by" => [
                "weight" => -2,
                "words" => ["support", "help"]
            ],
            "preceeded_by" => [
                "weight" => +2,
                "words" => ["feel", "thoughts"]
            ],
        ],
        "despair" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["hopelessness", "darkness"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["sadness", "emptiness"]
            ],
        ],
        "isolation" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["alone", "loneliness"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["depression", "isolate"]
            ],
        ],
        "pain" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["suffering", "agony"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["numbness", "self-harm"]
            ],
        ],
        "painful" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["suffering", "agony"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["numbness", "self-harm"]
            ],
        ],
        "broken" => [
            "base_weight" => +1,
            "anywhere" => [
                "weight" => +1,
                "words" => ["fragile", "shattered"]
            ],
            "in_sentence" => [
                "weight" => +2,
                "words" => ["heart", "spirit"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["hope", "healing"]
            ],
        ],
        "darkness" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["gloom", "desolation"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["light", "hope"]
            ],
        ],
        "lost" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["direction", "purpose"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["hope", "guidance"]
            ],
        ],
        "struggling" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["battle", "painful"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["overcome", "strength"]
            ],
        ],
        "struggle" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["battle", "painful"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["overcome", "strength"]
            ],
        ],
        "torment" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["anguish", "suffering"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["release", "peace"]
            ],
        ],
        "anguish" => [
            "base_weight" => +1,
            "anywhere" => [
                "weight" => +1,
                "words" => ["agony", "despair"]
            ],
            "in_sentence" => [
                "weight" => +2,
                "words" => ["suffering", "pain"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["hope", "healing"]
            ],
        ],
        "suffocate" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["choking", "strangling"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["breathe", "release"]
            ],
        ],
        "suffocating" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["choking", "strangling"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["breathe", "release"]
            ],
        ],
        "brokenness" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["fragility", "shattered"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["healing", "wholeness"]
            ],
        ],
        "despairing" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["hopelessness", "hopeless"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["hope", "resilience"]
            ],
        ],
        "despair" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["desolation", "misery"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["hope", "recovery"]
            ],
        ],
        "agony" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["anguish", "suffering"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["ease", "peace"]
            ],
        ],
        "numb" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["numbness", "emptiness"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["feeling", "sensitivity"]
            ],
        ],
        "suffocation" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["asphyxiation", "strangulation"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["breath", "freedom"]
            ],
        ],
        "suffer" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["pain", "torment"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["healing", "relief"]
            ],
        ],
        "lost" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["directionless", "confusion"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["find", "purpose"]
            ],
        ],
        "darkness" => [
            "base_weight" => +1,
            "in_sentence" => [
                "weight" => +2,
                "words" => ["gloom", "despair"]
            ],
            "followed_by" => [
                "weight" => +1,
                "words" => ["light", "hope"]
            ],
        ],
    ],
];