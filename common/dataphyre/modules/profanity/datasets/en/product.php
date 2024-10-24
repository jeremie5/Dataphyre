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

$cached_profanity_rulesets['commerce_product']=[
    "ruleset_type"=>"commerce_product",
    "rules"=>[
        "product"=>[
            "base_weight"=>+2,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["description", "details", "specifications"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["for sale", "available", "buy now"]
            ],
        ],
        "service"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["description", "details"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["offered", "available"]
            ],
        ],
        "item"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["description", "details"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["for sale", "available"]
            ],
        ],
        "offer"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["available", "for sale"]
            ],
        ],
        "sale"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["now", "limited time"]
            ],
        ],
        "buy"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["now", "purchase"]
            ],
        ],
        "package"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["deal", "bundle"]
            ],
        ],
        "buy now"=>[
            "base_weight"=>+2,
            "followed_by"=>[
                "weight"=>+2,
                "words"=>["limited time offer", "discount"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["available", "purchase"]
            ],
        ],
        "discount"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["code", "promo"]
            ],
        ],
        "shipping"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["options", "details"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["available", "delivery"]
            ],
        ],
        "guarantee"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["satisfaction", "refund"]
            ],
        ],
        "limited edition"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["collectible", "rare"]
            ],
        ],
        "customizable"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["personalized", "custom"]
            ],
        ],
        "brand new"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["unused", "fresh"]
            ],
        ],
        "money-back guarantee"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+2,
                "words"=>["refund", "return"]
            ],
        ],
        "subscription"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["plan", "membership"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["available", "monthly"]
            ],
        ],
        "bundle"=>[
            "base_weight"=>+2,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["deal", "package"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["available", "offer"]
            ],
        ],
        "premium"=>[
            "base_weight"=>+1,
            "followed_by"=>[
                "weight"=>+1,
                "words"=>["quality", "features"]
            ],
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["product", "service"]
            ],
        ],
        "exclusive"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["access", "offer"]
            ],
        ],
        "authentic"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["original", "genuine"]
            ],
        ],
        "handmade"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["crafted", "artisan"]
            ],
        ],
        "new"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["arrival", "release"]
            ],
        ],
        "limited stock"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["remaining", "available"]
            ],
        ],
        "bestseller"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["top", "popular"]
            ],
        ],
        "sale"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["price", "discount"]
            ],
        ],
        "guaranteed"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["satisfaction", "money-back"]
            ],
        ],
        "premium quality"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["crafted", "high-end"]
            ],
        ],
        "latest"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["technology", "innovation"]
            ],
        ],
        "eco-friendly"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["sustainable", "environmentally friendly"]
            ],
        ],
        "exclusive offer"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["limited time", "special"]
            ],
        ],
        "handcrafted"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["artisan", "made"]
            ],
        ],
        "premium brand"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["luxury", "high-end"]
            ],
        ],
        "fast shipping"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["delivery", "speed"]
            ],
        ],
        "premium materials"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["quality", "luxurious"]
            ],
        ],
        "free shipping"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["worldwide", "orders"]
            ],
        ],
        "satisfaction guarantee"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["refund", "return"]
            ],
        ],
        "eco-conscious"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["sustainability", "recyclable"]
            ],
        ],
        "high-quality"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["craftsmanship", "materials"]
            ],
        ],
        "fast and reliable"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["delivery", "shipping"]
            ],
        ],
        "best value"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["price", "affordable"]
            ],
        ],
        "reliable performance"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["efficiency", "dependable"]
            ],
        ],
        "stylish design"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["elegant", "modern"]
            ],
        ],
        "user-friendly"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["intuitive", "convenient"]
            ],
        ],
        "packaging"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["presentation", "luxurious"]
            ],
        ],
        "craftsmanship"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["artisan", "handmade"]
            ],
        ],
        "luxurious"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["elegant", "opulent"]
            ],
        ],
        "convenient"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["easy-to-use", "time-saving"]
            ],
        ],
        "exceptional"=>[
            "base_weight"=>+2,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["superior", "unmatched"]
            ],
        ],
        "eco-friendly"=>[
            "base_weight"=>+1,
            "followed_by_in_sentence"=>[
                "weight"=>+1,
                "words"=>["sustainable", "recyclable"]
            ],
        ],
        "premium"=>[
            "base_weight"=>+2,
        ],
        "durable"=>[
            "base_weight"=>+1,
        ],
        "sleek"=>[
            "base_weight"=>+1,
        ],
        "convenient"=>[
            "base_weight"=>+1,
        ],
        "reliable"=>[
            "base_weight"=>+1,
        ],
        "stylish"=>[
            "base_weight"=>+1,
        ],
        "premium"=>[
            "base_weight"=>+2,
        ],
        "versatile"=>[
            "base_weight"=>+1,
        ],
        "stylish"=>[
            "base_weight"=>+1,
        ],
        "convenient"=>[
            "base_weight"=>+1,
        ],
        "reliable"=>[
            "base_weight"=>+1,
        ],
        "exceptional"=>[
            "base_weight"=>+1,
        ],
        "efficient"=>[
            "base_weight"=>+1,
        ],
        "modern"=>[
            "base_weight"=>+1,
        ],
        "luxury"=>[
            "base_weight"=>+2,
        ],
        "advanced"=>[
            "base_weight"=>+1,
        ],
        "reliable"=>[
            "base_weight"=>+1,
        ],
        "sustainable"=>[
            "base_weight"=>+1,
        ],
        "premium"=>[
            "base_weight"=>+1,
        ],
        "ergonomic"=>[
            "base_weight"=>+1,
        ],
        "innovative"=>[
            "base_weight"=>+1,
        ],
        "stylish"=>[
            "base_weight"=>+1,
        ],
        "efficient"=>[
            "base_weight"=>+1,
        ],
        "sleek"=>[
            "base_weight"=>+1,
        ],
        "high-quality"=>[
            "base_weight"=>+2,
        ],
    ],
];