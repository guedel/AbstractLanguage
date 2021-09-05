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

use Guedel\AL\Datatype\{Structure, TypeName, Any};
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Declaration\TypeDecl;

/**
 * Description of ClassProgram
 *
 * @author Guedel <guedel87@live.fr>
 */
class StructProgram implements BaseTestProgram
{
  public function attend(): string
  {
    return join(PHP_EOL, [
        "TYPE mystruct: STRUCT",
        "\tVAR one: ANY",
        "\tVAR two: INTEGER",
        "END STRUCT",
    ]) . PHP_EOL;
  }

  public function code(): \Guedel\AL\Statement\Statement
  {
    return new TypeDecl(
        "mystruct",
        new Structure(
            new VariableDecl("one", Any::getType()),
            new VariableDecl("two", new TypeName("int"))
        )
    );
  }
}
