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
    public function __construct(private readonly ?string $message = null)
    {
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        return $visitor->visitComment($this);
    }
}
