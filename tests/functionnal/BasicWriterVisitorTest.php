<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Functionnal\AL;

use PHPUnit\Framework\TestCase;
use Guedel\AL\Runtime\BasicWriterVisitor;
use Guedel\AL\Runtime\Translator;
use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;
use Guedel\Tests\Mock\AL\Programs\Writer as Prog;
use Guedel\Stream\CodeWriter;

/**
 * Description of BasicWriterVisitorTest
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicWriterVisitorTest extends TestCase
{
    private BasicWriterVisitor $visitor;
    private Translator $translator;
    private CodeWriter $writer;

    public function setUp(): void
    {
        $this->writer = new CodeWriter();
        $this->translator = new Translator();
        $this->visitor = new BasicWriterVisitor($this->writer, $this->translator);
    }

    /**
     * @dataProvider programs
     * @coversNothing
     */
    public function testProgram(BaseTestProgram $p)
    {
        $p->code()->accept($this->visitor);
        $r = $this->writer->render();
        $this->assertEquals($p->expect(), $r);
    }


    public static function programs()
    {
        return [
        'empty module' => [new Prog\EmptyModuleProgram()],
        'hello world' => [new Prog\HelloWorldProgram()],
        'simple if' => [new Prog\SimpleIfProgram()],
        'if then else' => [new Prog\IfThenElseProgram()],
        'variable use' => [new Prog\VariableUseProgram()],
        'declare procedure' => [new Prog\DeclareProcProgram()],
        'loops' => [new Prog\LoopProgram()],
        'expressions' => [new Prog\ExpressionsProgram()],
        'declare function' => [new Prog\FunctionDeclProgram()],
        'declare type' => [new Prog\DeclareTypeProgram()],
        'structure' => [new Prog\StructProgram()],
        ];
    }
}
