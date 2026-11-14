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
 * Description of String
 *
 * @author Guedel <guedel87@live.fr>
 */
class StringOfChars implements Type, Convertible
{
    private $length;

    public function __construct($length = null)
    {
        $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
        $visitor->visitString($this);
    }

    public function fromBinaryData($data)
    {
        return unpack('a', $data);
    }

    public function toBinaryData($value): string
    {
        return pack('a', $value);
    }

    public function getSignature(): string
    {
        $ret = 'STRING';
        if ($this->length !== null) {
            $ret .= '*' . $this->length;
        }
        return $ret;
    }
}
