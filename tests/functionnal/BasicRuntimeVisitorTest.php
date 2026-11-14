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
use Guedel\AL\Runtime\BasicRuntimeVisitor;
use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;
use Guedel\Tests\Mock\AL\Programs\Runtime as Prog;

/**
 * Description of BasicRuntimeVisitorTest
 *
 * @author Guedel <guedel87@live.fr>
 */
class BasicRuntimeVisitorTest extends TestCase
{
    private BasicRuntimeVisitor $visitor;

    public function setUp(): void
    {
        $this->visitor = new BasicRuntimeVisitor();
    }

    /**
     * @dataProvider programs
     * @coversNothing
     */
    public function testProgram(BaseTestProgram $p)
    {
        $this->expectOutputString($p->expect());
        $this->visitor->run($p->code());
    }

    public static function programs()
    {
        return [
        'hello world' => [new Prog\HelloWorldProgram()],
        'printf hello' => [new Prog\PrintfProgram()],
        'variable use' => [new Prog\VariableUseProgram()],
        'php function call' => [new Prog\PhpFunctionCall()],
        'expression' => [new Prog\ExpressionsProgram()],
        'if then structure' => [new Prog\IfThenProgram()],
        'for structure' => [new Prog\ForProgram()],
        'while structure' => [new Prog\WhileProgram()],
        'simple user procedure call' => [new Prog\ProcProgram()],
        'user procedure call' => [new Prog\ProcParamProgram()],
        'simple user function call' => [new Prog\FuncProgram()],
        ];
    }
}
