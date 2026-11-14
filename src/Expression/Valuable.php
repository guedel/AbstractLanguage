<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Expression;

use Guedel\AL\Runtime\Visitor;
use Guedel\AL\Datatype\Type;

/**
 * Interface for all values
 *
 * @author Guedel <guedel87@live.fr>
 */
interface Valuable
{
    /**
     *
     * @param Visitor $visitor
     * @return mixed
     */
    public function evaluate(Visitor $visitor);
}
