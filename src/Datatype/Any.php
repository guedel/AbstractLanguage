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

use Guedel\AL\Runtime\Visitor;

/**
 * When type is undefined.
 *
 * @author Guedel <guedel87@live.fr>
 */
final class Any implements Type
{
    private static ?Any $instance = null;

    private function __construct()
    {
    }
    public function accept(Visitor $visitor)
    {
        $visitor->visitAny($this);
    }

    public function getSignature(): string
    {
        return 'any';
    }

    /**
     * @SuppressWarnings
     */
    public static function getType(): Any
    {
        if (null === self::$instance) {
            self::$instance = new Any();
        }
        return self::$instance;
    }
}
