<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Declaration;

use Guedel\AL\Builder;
use Guedel\AL\Datatype\Type;
use Guedel\AL\Declaration\TypeDecl;

trait DeclarationBuilder
{
    public function stmtType(string $name, Type $definition): Builder
    {
        $this->statements->add(new TypeDecl($name, $definition));
        return $this;
    }

    public function stmtProcedure(string $name, ParametersList $parameters = null): Builder
    {
        $ret = $this->stmtBegin();
        $this->statements->add(new ProcedureDecl($name, $parameters, $ret->statements));
        return $ret;
    }

    public function stmtFunction(
        string $name,
        Type $return_type,
        ParametersList $parameters = null
    ): Builder {
        $ret = $this->stmtBegin();
        $this->statements->add(new FunctionDecl($name, $return_type, $parameters, $ret->statements));
        return $ret;
    }

    public function stmtModule(string $name): Builder
    {
        $ret = $this->stmtBegin();
        $this->statements->add(new Module($name, $ret->statements));
        return $ret;
    }
}
