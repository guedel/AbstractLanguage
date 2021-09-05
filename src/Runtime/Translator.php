<?php

  /*
   * The MIT License
   *
   * Copyright 2018 Guedel <guedel87@live.fr>.
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy
   * of this software and associated documentation files (the "Software"), to deal
   * in the Software without restriction, including without limitation the rights
   * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
   * copies of the Software, and to permit persons to whom the Software is
   * furnished to do so, subject to the following conditions:
   *
   * The above copyright notice and this permission notice shall be included in
   * all copies or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   * THE SOFTWARE.
   */

  namespace Guedel\AL\Runtime;

  /**
   * Translate of language tokens
   *
   * @author Guedel <guedel87@live.fr>
   */
class Translator
{
    const FRENCH = 'fr';
    const ENGLISH = 'en';

    private static $words = array(
    'fr' => array(
      'ANY' => 'QUELCONQUE',
      'ARRAY' => 'TABLEAU',
      'BEGIN' => 'DEBUT',
      'DECIMAL' => 'DECIMAL',
      'DO' => 'FAIRE',
      'EACH' => 'CHAQUE',
      'ELSE' => 'SINON',
      'END' => 'FIN',
      'ELSE' => 'SINON',
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
    ),
    );

    private $language;

    public function __construct($language = 'en')
    {
        $this->language = $language;
    }

    public function _t(string $word): string
    {
        if ($this->language == self::ENGLISH) {
            return $word;
        }
        try {
            return self::$words[$this->language][$word];
        } catch (Exception $ex) {
        }
        return $word;
    }
}
