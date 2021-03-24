<?php

/*
 * The MIT License
 *
 * Copyright 2021 Guedel <guedel87@live.fr>.
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

use PHPUnit\Framework\TestCase;

use Guedel\AL\Runtime\BasicWriterVisitor;
use Guedel\AL\Runtime\Translator;
use Guedel\Tests\Mock\AL\Programs as Prog;
use Guedel\Stream\CodeWriter;

/**
 * Description of BasicWriterVisitorTest
 *
 * @author Guedel <guedel87@live.fr>
 * @covers BasicWriterVisitor
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
   */
  public function testProgram(Prog\BaseTestProgram $p)
  {
    $p->code()->accept($this->visitor);
    $r = $this->writer->render();
    $this->assertEquals($p->attend(), $r);
  }

  
  public function programs()
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
