<?php

namespace App\Helpers;

class Translate
{
    public static function rus2translit($string): string
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            ' ' => '-', '-' => '-', '_' => '-'
        ];

        $result = '';

        foreach (mb_str_split(mb_strtolower($string), 1) as $char) {
            if (!isset($converter[$char])) {
                continue;
            }

            $result .= $converter[$char];
        }

        return $result;
    }
}
