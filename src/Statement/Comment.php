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
 * Description of Comment
 *
 * @author Guedel <guedel87@live.fr>
 */
class Comment implements \Guedel\AL\Statement\Statement
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
    public function getMessage()
    {
        return $this->message;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->visitComment($this);
    }
}
