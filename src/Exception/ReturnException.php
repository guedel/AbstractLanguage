<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Exception;

/**
 * Description of ReturnException
 *
 * @author Guedel <guedel87@live.fr>
 */
class ReturnException extends \Exception
{
    private $returnvalue;

    public function __construct($returnvalue)
    {
        $this->returnvalue = $returnvalue;
        parent::__construct("return invoked");
    }
}
