<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Unit\AL\Runtime;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\Translator;

/**
 * @covers \Guedel\AL\Runtime\Translator
 */
class TranslatorTest extends TestCase
{
    public function testEnglishWord()
    {
        $translator = new Translator(Translator::ENGLISH);
        $word = 'THEN';
        $this->assertEquals($word, $translator->tr($word));
    }

    public function testEnglishWordDoesntExist()
    {
        $translator = new Translator(Translator::ENGLISH);
        $word = 'HELLO_WORLD';
        $this->assertEquals($word, $translator->tr($word));
    }

    public function testFrenchWord()
    {
        $translator = new Translator(Translator::FRENCH);
        $word = 'THEN';
        $this->assertEquals('ALORS', $translator->tr($word));
    }

    public function testFrenchWordDoesntExist()
    {
        $translator = new Translator(Translator::FRENCH);
        $word = 'HELLO_WORLD';
        $this->assertEquals($word, $translator->tr($word));
    }

    public function testLanguageDoesntExist()
    {
        $translator = new Translator('DOESNT EXIST');
        $word = 'HELLO_WORLD';
        $this->assertEquals($word, $translator->tr($word));
    }
}
