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

$cached_profanity_rulesets['product_adult']=[
    "ruleset_type"=>"product_adult",
    "rules"=>[
        "adult"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+1,
                "words"=>["nude", "nudes", "18", "eighteen", "18+", "mature", "explicit"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["only"]
            ],
            "not_followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["for", "sale"]
            ],
            "not_in_sentence"=>[
                "weight"=>+1,
                "words"=>["kid", "child", "children", "clothing", "shoe", "shoes", "diapers", "medecine", "drugs", "drug", "syrop", "lozenge", "pain"]
            ],
        ],
        "porn"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["movie", "video", "actress", "nude", "nudes", "18", "eighteen", "18+", "mature", "explicit"]
            ],
        ],
        "pornography"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["movie", "video", "actress", "nude", "nudes", "18", "eighteen", "18+", "mature", "explicit"]
            ],
        ],
        "pornographic"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["movie", "video", "actress", "nude", "nudes", "18", "eighteen", "18+", "mature", "explicit"]
            ],
        ],
        "explicit"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["movie", "video", "music", "content", "material", "lyrics"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["age-restricted"]
            ],
        ],
        "nsfw"=>[
            "base_weight"=>+1,
            "in_sentence"=>[
                "weight"=>+1,
                "words"=>["warning", "content", "material", "pic", "pics", "picture", "pictures", "video", "videos"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["content", "material"]
            ],
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["warning", "viewer discretion advised"]
            ],
        ],
        "sexy"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+1,
                "words"=>["adult", "adults", "toys", "accessories", "content", "material", "pics", "picture", "pictures", "video", "videos"]
            ],
        ],
        "sex"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["adult", "adults", "toys", "accessories"]
            ],            
			"immediately_followed_by_in_sentence_in_sentence"=>[
                "weight"=>+5,
                "words"=>["toys", "doll", "dolls", "worker", "workers"]
            ],
            "not_preceeded_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["children", "underage"]
            ],
        ],
        "sexual"=>[
            "base_weight"=>+1,
        ],
        "golden"=>[
            "base_weight"=>0,
            "immediately_followed_by_in_sentence_in_sentence"=>[
                "weight"=>+5,
                "words"=>["shower"]
            ],
        ],
        "erotic"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["lingerie", "books"]
            ],
        ],
        "pleasure"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["enhancers", "stimulators"]
            ],
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["intimate"]
            ],
        ],
        "bondage"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["restraints", "fetish", "handcuffs", "bdsm"]
            ],
        ],
        "vibrators"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["powerful", "multi-speed"]
            ],
        ],
        "vibrator"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["powerful", "multi-speed", "throbbing", "pulsating", "heating", "silicone", "pvc", "jelly", "tpu", "tpe"]
            ],
            "not_in_sentence"=>[
                "weight"=>-2,
                "words"=>["concrete"]
            ],
        ],
        "vibrating"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["powerful", "multi-speed", "throbbing", "pulsating", "heating", "silicone", "pvc", "jelly", "tpu", "tpe"]
            ],
            "not_in_sentence"=>[
                "weight"=>-2,
                "words"=>["concrete"]
            ],
        ],
        "lingerie"=>[
            "base_weight"=>0,
            "preceeded_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["sexy"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["lace", "satin", "leather", "latex", "pvc"]
            ],
        ],
        "fetish"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+1,
                "words"=>["kink", "squirt", "squirting", "squirted","foot", "golden"]
            ],
            "in_sentence"=>[
                "weight"=>-2,
                "words"=>["weird", "odd", "abnormal"]
            ],
        ],
        "dildo"=>[
            "base_weight"=>+4,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "artificial", "dog", "octopus", "tongue", "tentacle", "horse", "squirt", "squirting", "squirted", "realistic", "silicone", "pvc", "rubber", "liquid", "wet", "hard", "soft", "long", "simulation", "cup", "suction", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "dildos"=>[
            "base_weight"=>+4,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "artificial", "dog", "tentacle", "horse", "squirt", "squirting", "squirted", "realistic", "silicone", "pvc", "rubber", "liquid", "wet", "hard", "soft", "long", "simulation", "cup", "suction", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "dilator"=>[
            "base_weight"=>+3,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "artificial", "dog", "tentacle", "horse", "squirt", "squirting", "squirted", "realistic", "silicone", "pvc", "rubber", "liquid", "wet", "hard", "soft", "long", "simulation", "cup", "suction", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "strap on"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "dildo", "realistic", "simulation", "cup", "suction", "harness", "adjustable", "rubber", "size", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "strap-on"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "dildo", "realistic", "simulation", "cup", "suction", "harness", "adjustable", "rubber", "size", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "strap-ons"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["phallus", "dick", "dildo", "realistic", "simulation", "cup", "suction", "harness", "adjustable", "rubber", "size", "sex", "female", "gay", "male", "lesbian"]
            ],
        ],
        "missionary"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["sex", "female", "gay", "male", "lesbian", "position"]
            ],
        ],
        "fuck"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+5,
                "words"=>["squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
			"immediately_followed_by_in_sentence"=>[
                "weight"=>-5,
                "words"=>["yeah", "yes"]
			],
        ],
        "fucks"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+5,
                "words"=>["squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
			"immediately_followed_by_in_sentence"=>[
                "weight"=>-5,
                "words"=>["yeah", "yes"]
			],
        ],
        "g-spot"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
        ],
        "rough"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["mouth", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
        ],
        "pounding"=>[
            "base_weight"=>1,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["mouth", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
        ],
        "anally"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+6,
                "words"=>["mouth", "fill", "cock", "dick", "cum", "semen", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore"]
            ],
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["pleasure", "beads", "massage", "massager", "fuck", "fucking", "pounding", "pounded"]
            ],
        ],
        "anal"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+6,
                "words"=>["mouth", "fill", "cock", "dick", "cum", "semen", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore"]
            ],
            "followed_by_in_sentence_in_sentence"=>[
                "weight"=>+2,
                "words"=>["plug", "beads", "pleasure", "massage", "massager", "fuck", "fucking", "pounding", "pounded"]
            ],
            "not_in_sentence"=>[
                "weight"=>-2,
                "words"=>["cream", "medical", "ointment", "antibiotic"]
            ],
        ],
        "anus"=>[
            "base_weight"=>+3,
            "in_sentence"=>[
                "weight"=>+6,
                "words"=>["fill", "cock", "dick", "cum", "semen", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore"]
            ],
            "not_in_sentence"=>[
                "weight"=>-2,
                "words"=>["cream", "medical", "ointment", "antibiotic"]
            ],
        ],
        "pussy"=>[
            "base_weight"=>+5,
            "in_sentence"=>[
                "weight"=>+6,
                "words"=>["fill", "cock", "dick", "cum", "semen", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore"]
            ],
            "not_in_sentence"=>[
                "weight"=>+2,
                "words"=>["cream", "medical", "ointment", "antibiotic"]
            ],
        ],
        "tight"=>[
            "base_weight"=>0,
            "in_sentence"=>[
                "weight"=>+1,
                "words"=>["cock", "dick", "cum", "semen", "squirt", "squirting", "squirted", "backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
        ],
        "prolapse"=>[
            "base_weight"=>+1,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["backdoor", "pussy", "anus", "anal", "anally", "prostitute", "gape", "slut", "whore", "vagina", "vaginal", "vaginally"]
            ],
        ],
        "backdoor"=>[
            "base_weight"=>+1,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["plug", "beads", "dilo", "massager", "fuck", "fucking"]
            ],
            "immediately_preceeded_by"=>[
                "weight"=>+2,
                "words"=>["for"]
            ],
            "preceeded_by"=>[
                "weight"=>+2,
                "words"=>["repair", "new", "emergency"]
            ],
        ],
        "prostitute"=>[
            "base_weight"=>+3,
        ],
        "whore"=>[
            "base_weight"=>+3,
        ],
        "penis"=>[
            "base_weight"=>+2,
            "in_sentence"=>[
                "weight"=>+2,
                "words"=>["enlargement"]
            ],
        ],
        "dick"=>[
            "base_weight"=>0,
            "in_sentence"=>[
                "weight"=>+3,
                "words"=>["enlargement", "cock", "dick", "cum", "semen"]
            ],
        ],
        "slut"=>[
            "base_weight"=>+3,
        ],
        "rectum"=>[
            "base_weight"=>+3,
        ],
        "scrotum"=>[
            "base_weight"=>+3,
        ],
        "cervix"=>[
            "base_weight"=>+3,
        ],
        "clitoris"=>[
            "base_weight"=>+3,
        ],
        "prostate"=>[
            "base_weight"=>+3,
        ],
        "gape"=>[
            "base_weight"=>+3,
        ],
        "gaping"=>[
            "base_weight"=>+3,
        ],
        "vagina"=>[
            "base_weight"=>+3,
        ],
        "vaginal"=>[
            "base_weight"=>+4,
        ],
        "vaginally"=>[
            "base_weight"=>+4,
        ],
        "deepthroat"=>[
            "base_weight"=>+10,
        ],
        "throatpie"=>[
            "base_weight"=>+10,
        ],
        "masturbator"=>[
            "base_weight"=>+10,
        ],
        "masturbators"=>[
            "base_weight"=>+10,
        ],
    ],
];