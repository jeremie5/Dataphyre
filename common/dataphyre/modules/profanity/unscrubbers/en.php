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
* forbidden unless prior written permission is obtained from Shopiro Ltd.
*/

$cached_unscrub_rulesets['en']=[
    'sequential_chars_split'=>[
        ['pattern'=>'/(([a-z])-){2,}/i', 'replace'=>['-'], 'replacement'=>''],
		['pattern'=>'/(([a-z]) ){2,}/i', 'replace'=>[' '], 'replacement'=>''],
		['pattern'=>'/(([a-z])~){2,}/i', 'replace'=>['~'], 'replacement'=>''],
		['pattern'=>'/(([a-z])>){2,}/i', 'replace'=>['>'], 'replacement'=>''],
		['pattern'=>'/(([a-z])<){2,}/i', 'replace'=>['<'], 'replacement'=>''],
		['pattern'=>'/(([a-z])=){2,}/i', 'replace'=>['='], 'replacement'=>''],
		['pattern'=>'/(([a-z])+){2,}/i', 'replace'=>['+'], 'replacement'=>''],
		['pattern'=>'/(?<=\p{L})\/+(?=\p{L})/', 'replace'=>['/'], 'replacement'=>''],
		['pattern'=>'/(?<=\p{L})\\\+(?=\p{L})/', 'replace'=>['\\'], 'replacement'=>''],
    ],
    'domain_disguised'=>[
        ['pattern'=>'/([a-z0-9.-]+) dot ([a-z]{2,})/i', 'replace'=>['dot'], 'replacement'=>'.'],
        ['pattern'=>'/([a-z0-9.-]+) (dot) ([a-z]{2,})/i', 'replace'=>['(dot)'], 'replacement'=>'.'],
		['pattern'=>'/([a-z0-9.-]+) point ([a-z]{2,})/i', 'replace'=>['point'], 'replacement'=>'.'],
        ['pattern'=>'/([a-z0-9.-]+) (point) ([a-z]{2,})/i', 'replace'=>['(point)'], 'replacement'=>'.'],
    ],
    'email_disguised'=>[
        ['pattern'=>'/([a-z0-9._%+-]+) at ([a-z0-9.-]+ dot [a-z]{2,})/i', 'replace'=>[' at ',' dot '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) at ([a-z0-9.-]+ (dot) [a-z]{2,})/i', 'replace'=>[' at ',' (dot) '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) (at) ([a-z0-9.-]+ dot [a-z]{2,})/i', 'replace'=>[' (at) ',' dot '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) @ ([a-z0-9.-]+ dot [a-z]{2,})/i', 'replace'=>[' @ ',' dot '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) at ([a-z0-9.-]+ . [a-z]{2,})/i', 'replace'=>[' at ',' dot '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) @ ([a-z0-9.-]+ . [a-z]{2,})/i', 'replace'=>[' @ ',' . '], 'replacement'=>['@', '.']],
        ['pattern'=>'/([a-z0-9._%+-]+) (at) ([a-z0-9.-]+ (dot) [a-z]{2,})/i', 'replace'=>[' (at) ',' (dot) '], 'replacement'=>['@', '.']],
    ],
    'deceptive_characters'=>[
        'map'=>[
            'а'=>'a','в'=>'b','е'=>'e','к'=>'k','м'=>'m','н'=>'h','о'=>'o','р'=>'p','с'=>'c','т'=>'t','у'=>'y','х'=>'x','ѕ'=>'s','і'=>'i',
            'ј'=>'j','ў'=>'u','ғ'=>'f','ӏ'=>'l','ӧ'=>'ö','α'=>'a','β'=>'b','ε'=>'e','η'=>'h','ι'=>'i','κ'=>'k','ν'=>'n',
            'ο'=>'o','ρ'=>'p','υ'=>'u','χ'=>'x','ƒ'=>'f','ȷ'=>'j','ł'=>'l','ș'=>'s','ŧ'=>'t','ʊ'=>'u','ʏ'=>'y','ʑ'=>'z'
        ]
    ],
];