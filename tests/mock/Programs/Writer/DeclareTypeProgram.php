<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\Tests\Mock\AL\Programs\Writer;

use Guedel\Tests\Mock\AL\Programs\BaseTestProgram;
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
    public function expect(): string
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

    /**
     * @return \Guedel\AL\Statement\Statement
     */
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
