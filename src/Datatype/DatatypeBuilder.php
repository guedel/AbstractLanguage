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

trait DatatypeBuilder
{
    public function enumType(string ...$symbols): Enumeration
    {
        return new Enumeration(...$symbols);
    }

    public function arrayType($min, $max, Type $type)
    {
        return new ArrayOf($type, $min, $max);
    }

    public function stringType($len = null)
    {
        return new StringOfChars($len);
    }
}
