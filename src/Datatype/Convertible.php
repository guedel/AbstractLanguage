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
 *
 * @author Guedel <guedel87@live.fr>
 */
interface Convertible
{
    public function toBinaryData($value): string;
    public function fromBinaryData($data);
}
