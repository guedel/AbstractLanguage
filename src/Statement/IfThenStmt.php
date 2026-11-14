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

use Guedel\AL\Expression\Valuable;

/**
 * IF $iftest THEN $thenpart ELSE $elsepart
 *
 * @author Guedel <guedel87@live.fr>
 */
class IfThenStmt implements Statement
{
    public function __construct(
        protected readonly Valuable $iftest,
        protected readonly Statement $thenpart,
        protected readonly ?Statement $elsepart = null
    ) {
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitIfThenStmt($this);
    }

    public function getIfTest(): Valuable
    {
        return $this->iftest;
    }
    public function getThenPart(): Statement
    {
        return $this->thenpart;
    }
    public function getElsePart(): ?Statement
    {
        return $this->elsepart;
    }
}
