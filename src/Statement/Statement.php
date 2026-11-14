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
 * Interface of Statement
 *
 * @author Guedel <guedel87@live.fr>
 */
interface Statement
{
    public function accept(\Guedel\AL\Runtime\Visitor $visitor);
}
