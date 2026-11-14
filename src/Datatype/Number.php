<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Datatype;

/**
 * Description of Number
 *
 * @author Guedel <guedel87@live.fr>
 */
class Number implements Type
{
    private ?int $length;
    private ?int $precision;

    public function __construct(?int $length = null, ?int $precision = null)
    {
        $this->length = $length;
        $this->precision = $precision;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitNumber($this);
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function getSignature(): string
    {
        return sprintf('number(%d,%d)', $this->length, $this->precision);
    }
}
