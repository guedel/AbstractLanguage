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

namespace Guedel\Tests\Mock\AL\Programs;

use Guedel\AL\Statement\StatementList;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Datatype\{ Enumeration, Number, StringOfChars, Reference, ArrayOf, Any, TypeName};

/**
 * Description of DeclareTypeProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class DeclareTypeProgram implements BaseTestProgram
{
  //put your code here
  public function attend(): string
  {
    return join(PHP_EOL, [
        "TYPE sample1: STRING * 50",
        "TYPE sample2: ARRAY [1, 10] OF INTEGER",
        "TYPE sample3: {mercure, venus, earth, mars}",
        "TYPE sample4: REF OF sample3",
        "TYPE sample5: NUMBER",
        "TYPE sample6: NUMBER(8, 3)",
    ]) . PHP_EOL;
  }

  public function code(): \Guedel\AL\Statement\Statement
  {
    return new StatementList(
        new TypeDecl("sample1", new StringOfChars(50)),
        new TypeDecl("sample2", new ArrayOf(new TypeName(TypeName::DT_INTEGER), 1, 10)),
        new TypeDecl("sample3", new Enumeration("mercure", "venus", "earth", "mars")),
        new TypeDecl("sample4", new Reference(new TypeName("sample3"))),
        new TypeDecl("sample5", new Number()),
        new TypeDecl("sample6", new Number(8, 3)),
    );
  }
}
