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
 * Description of BaseType
 *
 * @author Guedel <guedel87@live.fr>
 */
interface Type
{
    public function accept(\Guedel\AL\Runtime\Visitor $visitor);
    public function getSignature(): string;
}
