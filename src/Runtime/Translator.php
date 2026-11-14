<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Runtime;

/**
 * Translate of language tokens
 *
 * @author Guedel <guedel87@live.fr>
 */
class Translator
{
    public const string FRENCH = 'fr';
    public const string ENGLISH = 'en';

    private static $words = [
    'fr' => [
      'ANY' => 'QUELCONQUE',
      'ARRAY' => 'TABLEAU',
      'BEGIN' => 'DEBUT',
      'DECIMAL' => 'DECIMAL',
      'DO' => 'FAIRE',
      'EACH' => 'CHAQUE',
      'ELSE' => 'SINON',
      'END' => 'FIN',
      'IF' => 'SI',
      'IN' => 'DANS',
      'INTEGER' => 'ENTIER',
      'FLOAT' => 'FLOTTANT',
      'FOR' => 'POUR',
      'FROM' => 'DEPUIS',
      'FUNCTION' => 'FONCTION',
      'OF' => 'DE',
      'PROCEDURE' => 'PROCEDURE',
      'REF' => 'REF',
      'STEP' => 'PAS DE',
      'STRING' => 'CHAINE',
      'TO' => 'A',
      'THEN' => 'ALORS',
      'TYPE' => 'TYPE',
      'VAR' => 'VAR',
      'WHILE' => 'TANT QUE',
    ],
    ];

    public function __construct(private $language = self::ENGLISH)
    {
    }

    public function tr(string $word): string
    {
        if ($this->language == self::ENGLISH) {
            return $word;
        }
        return self::$words[$this->language][$word] ?? $word;
    }
}
