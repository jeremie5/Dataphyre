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