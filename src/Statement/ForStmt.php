<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Statement;

use Guedel\AL\Expression\Expression;
use Guedel\AL\Expression\Valuable;
use Guedel\AL\Runtime\Visitor;

/**
 * FOR $varname FROM $initial TO $final [STEP $increment] DO $statement
 *
 * @author Guedel <guedel87@live.fr>
 */
class ForStmt implements Statement
{
    private string $varname;
    private Valuable $initial;
    private Valuable $final;
    private Valuable $increment;
    private ?Statement $statement;

    public function __construct(
        string $varnmame,
        Valuable $initial,
        Valuable $final,
        Valuable $increment,
        Statement $statement = null
    ) {
        $this->varname = $varnmame;
        $this->initial = $initial;
        $this->final = $final;
        $this->increment = $increment;
        $this->statement = $statement;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitForStmt($this);
    }

    public function getVariableName(): string
    {
        return $this->varname;
    }

    public function getInitial(): Valuable
    {
        return $this->initial;
    }

    public function getFinal(): Valuable
    {
        return $this->final;
    }

    public function getIncrement(): Valuable
    {
        return $this->increment;
    }

    public function getStatement(): ?Statement
    {
        return $this->statement;
    }
}
