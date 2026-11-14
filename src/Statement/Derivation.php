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

/**
 * Description of Derivation
 *
 * @author guillaume
 */
trait Derivation
{
    private $statement;

    public function getStatement(): Statement
    {
        return $this->statement;
    }

    public function setStatement($stmt)
    {
        $this->statement = $stmt;
    }
}
