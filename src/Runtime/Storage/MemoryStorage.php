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
 * Description of newPHPClass
 *
 * @author Guedel <guedel87@live.fr>
 */
class MemoryStorage implements BasicStorage
{
    private $memory = "";
    private $size;

    /**
     *
     * @var string memory unallocated
     */
    private const string UNDEF = "\024";

    public function __construct($size)
    {
        $this->size = $size;
        $this->memory = str_repeat(self::UNDEF, $size); // ctrl-U
    }

    /**
     * Récupère les octets
     * @param int $address
     * @param int $count
     * @return string
     * @throws \OverflowException
     */
    public function getBytes(int $address, int $count): string
    {
        if ($address < 0 || $address > $this->size - $count) {
            throw new \OverflowException();
        }
        return substr($this->memory, $address, $count);
    }

    /**
     * Emission de données sous forme d'octets
     * @param int $address
     * @param string $bytes
     * @throws \OverflowException
     */
    public function putBytes(int $address, string $bytes): int
    {
        $len = strlen($bytes);
        if ($address < 0 || $address > $this->size - $len) {
            throw new \OverflowException();
        }
        for ($index = 0; $index < $len; ++$index, ++$address) {
            $this->memory[$address] = $bytes[$index];
        }
        return $len;
    }

    /**
     * Récupère la première adresse libre capable de contenir l'espace nécessaire
     * @param int $size
     * @param int $start Adresse de départ pour la recherche
     * @return int l'adresse trouvée
     */
    public function getFreeAddress(int $size, int $start = 0): int
    {
        $ok = true;
        $index = 0;
        do {
            $start = $this->getNextFreeByte($start + $index);
            for ($index = $start + 1; $index < $start + $size; ++$index) {
                $ok = ($ok && $this->memory[$index] == self::UNDEF);
            }
            if (! $ok) {
                $start = $this->getNextFreeByte($start + $size);
            }
        } while (! $ok && $index < $this->size);
        return $start;
    }

    /**
     * Récupère l'adresse du prochain octet libre
     * @param int $start adresse de départ
     * @return int adresse trouvée
     * @throws \OverflowException
     */
    private function getNextFreeByte(int $start): int
    {
        for ($index = $start; $index < $this->size; ++$index) {
            if ($this->memory[$index] == self::UNDEF) {
                return $index;
            }
        }
        throw new \OverflowException();
    }

    public function retrieveObject(int $address): \stdClass
    {
        // TODO
        return new \stdClass();
    }

    public function storeObject(\stdClass $value, int $address)
    {
        // TODO
    }
}
