<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Runtime\Storage;

/**
 * Description of Storage
 *
 * @author Guedel <guedel87@live.fr>
 */
interface BasicStorage
{
    public function getFreeAddress(int $size): int;

    public function putBytes(int $address, string $bytes): int;
    public function getBytes(int $address, int $count): string;

    public function storeObject(\stdClass $value, int $address);
    public function retrieveObject(int $address): \stdClass;
}
