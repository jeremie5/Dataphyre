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

$cached_profanity_rulesets['dysphemistic_swearing']=[
    "ruleset_type"=>"dysphemistic_swearing",
    "rules"=>[
        "cunt"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["muscle", "punch"]
            ],
            "not_preceeded_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["whiny", "crybaby"]
            ],
        ],
        "motherfucker"=>[
            "base_weight"=>+5,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["pathetic", "wimpy"]
            ],
        ],
        "cockhead"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["around", "off"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["total", "complete"]
            ],
        ],
        "dickwad"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["insecure", "idiotic"]
            ],
        ],
        "fuckwit"=>[
            "base_weight"=>+4,
            "immediately_followed_by"=>[
                "weight"=>-5,
                "words"=>["that", "sake"]
            ],
        ],
        "pissface"=>[
            "base_weight"=>+2,
            "not_immediately_followed_by"=>[
                "weight"=>+1,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "ugly"]
            ],
        ],
        "shitbag"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "preceeded_by_in_sentence"=>[
                "weight"=>-2,
                "words"=>["what", "the"]
            ],
        ],
        "wanker"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["idiotic", "useless"]
            ],
        ],
        "douche"=>[
            "base_weight"=>+2,
            "not_followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["bag", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["annoying", "arrogant"]
            ],
        ],
        "scumbag"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["despicable", "disgusting"]
            ],
        ],
        "fucknugget"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["complete", "utter"]
            ],
        ],
        "dickweed"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["pathetic", "useless"]
            ],
        ],
        "wankstain"=>[
            "base_weight"=>+4,
            "immediately_followed_by"=>[
                "weight"=>-5,
                "words"=>["that", "sake"]
            ],
        ],
        "shithead"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
        ],
        "bastard"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["child", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["heartless", "cruel"]
            ],
        ],
        "assclown"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
        ],
        "dickhead"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "worthless"]
            ],
        ],
        "shit stain"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["on", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["disgusting", "filthy"]
            ],
        ],
        "asshole"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "ignorant"]
            ],
        ],
        "douchecanoe"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "immediately_followed_by"=>[
                "weight"=>-4,
                "words"=>["that", "sake"]
            ],
        ],
        "clusterfuck"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence"=>[
                "weight"=>+3,
                "words"=>["of", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["total", "epic"]
            ],
        ],
        "dickwaffle"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["around", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "shitshow"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence"=>[
                "weight"=>+3,
                "words"=>["of", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["total", "epic"]
            ],
        ],
        "cockwomble"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence"=>[
                "weight"=>+3,
                "words"=>["around", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["utter", "complete"]
            ],
        ],
        "asswipe"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "preceeded_by"=>[
                "weight"=>-2,
                "words"=>["freakin'", "goddamn"]
            ],
        ],
        "twatwaffle"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["around", "you"]
            ],
        ],
        "dicknose"=>[
            "base_weight"=>+4,
            "immediately_followed_by"=>[
                "weight"=>-5,
                "words"=>["that", "sake"]
            ],
            "preceeded_by_in_sentence"=>[
                "weight"=>-3,
                "words"=>["what", "the"]
            ],
        ],
        "fuckbucket"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["complete", "utter"]
            ],
        ],
        "cockgoblin"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "dickknuckle"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["around", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "asshat"=>[
            "base_weight"=>+4,
            "immediately_followed_by"=>[
                "weight"=>-5,
                "words"=>["that", "sake"]
            ],
            "preceeded_by_in_sentence"=>[
                "weight"=>-3,
                "words"=>["what", "the"]
            ],
        ],
        "fuckknuckle"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "not_preceeded_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "shitbag"=>[
            "base_weight"=>+4,
            "not_followed_by_in_sentence"=>[
                "weight"=>+3,
                "words"=>["around", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["total", "absolute"]
            ],
        ],
        "twatface"=>[
            "base_weight"=>+3,
            "not_followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["around", "you"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "twatlips"=>[
            "base_weight"=>+3,
            "immediately_followed_by"=>[
                "weight"=>-4,
                "words"=>["that", "sake"]
            ],
            "not_preceeded_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "assmunch"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "not_followed_by_in_sentence_in_sentence"=>[
                "weight"=>-2,
                "words"=>["what", "the"]
            ],
        ],
        "shitnugget"=>[
            "base_weight"=>+4,
            "not_immediately_followed_by"=>[
                "weight"=>+3,
                "words"=>["off", "you"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>-2,
                "words"=>["what", "the"]
            ],
        ],
        "cuntwaffle"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "preceeded_by"=>[
                "weight"=>-2,
                "words"=>["stupid", "fucking"]
            ],
        ],
        "douchewaffle"=>[
            "base_weight"=>+3,
            "immediately_followed_by"=>[
                "weight"=>-4,
                "words"=>["that", "sake"]
            ],
            "not_preceeded_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["stupid", "idiotic"]
            ],
        ],
        "cuntmuffin"=>[
            "base_weight"=>+3,
            "not_immediately_followed_by"=>[
                "weight"=>+2,
                "words"=>["of", "you"]
            ],
            "immediately_followed_by"=>[
                "weight"=>-4,
                "words"=>["that", "sake"]
            ],
            "preceeded_by"=>[
                "weight"=>-2,
                "words"=>["stupid", "fucking"]
            ],
        ],
    ],
];