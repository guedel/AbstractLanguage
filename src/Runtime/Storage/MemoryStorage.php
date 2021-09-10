<?php

  /*
   * The MIT License
   *
   * Copyright 2018 Guedel <guedel87@live.fr>.
   *
   * Permission is hereby granted, free of charge, to any person obtaining a copy
   * of this software and associated documentation files (the "Software"), to deal
   * in the Software without restriction, including without limitation the rights
   * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
   * copies of the Software, and to permit persons to whom the Software is
   * furnished to do so, subject to the following conditions:
   *
   * The above copyright notice and this permission notice shall be included in
   * all copies or substantial portions of the Software.
   *
   * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   * THE SOFTWARE.
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
     * @var char memory unallocated
     */
  private static $UNDEF = "\024";

  public function __construct($size)
  {
      $this->size = $size;
      $this->memory = str_repeat(self::$UNDEF, $size); // ctrl-U
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
        $ok = ($ok && $this->memory[$index] == self::$UNDEF);
      }
      if (! $ok) {
          $start = $this->getNextFreeByte($start + $size);
      }
    } while (! $ok && $index < $this->size);
      return $start;
  }

    /**
     * Récupère l'adresse du prochain octet libre
     * @param type $start adresse de départ
     * @return int adresse trouvée
     * @throws \OverflowException
     */
  private function getNextFreeByte($start): int
  {
    for ($index = $start; $index < $this->size; ++$index) {
      if ($this->memory[$index] == self::$UNDEF) {
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
