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

  namespace Guedel\AL\Datatype;
  /**
   * Description of Integer
   *
   * @author Guedel <guedel87@live.fr>
   */
  class Integer extends Primary
  {
    private $unsigned = false;
    /**
     *
     * @var int Taille en bits de la taille du stockage.
     */
    private $size = 64; // taille en bits
    // private $realsize = 64;

    public function __construct($size = 8, $unsigned = false)
    {
      if ($size > 64) {
        throw new \OverflowException('the size of ' . $this->size . 'is not supported. Please use bigint instead');
      }
      $this->unsigned = $unsigned;
      $this->size = $size;
      // $this->realsize = (intdiv($size, 8) + (($size % 8) > 0 ? 1 : 0)) * 8;
    }

    public function get_full_name(): string
    {
      return parent::get_full_name() . '.' . $this->get_name();
    }

    public function get_name(): string
    {
      return sprintf('integer(%d)', $this->size);
    }

    public function to_binary_data($value): string
    {
      if ($this->unsigned) {
        if ($this->size <= 8) {
            return pack('C', $value);
        } elseif ($this->size <= 16) {
            return pack('S', $value);
        } elseif ($this->size <= 32) {
            return pack('L', $value);
        } elseif ($this->size <= 64) {
            return pack('Q', $value);
        }
      } else {
        if ($this->size <= 8) {
            return pack('c', $value);
        } elseif ($this->size <= 16) {
            return pack('s', $value);
        } elseif ($this->size <= 32) {
            return pack('l', $value);
        } elseif ($this->size <= 64) {
            return pack('q', $value);
        }
      }
      throw new \OverflowException('the size of ' . $this->size . 'is not supported');
    }

    public function from_binary_data($data)
    {
      if ($this->unsigned) {
        if ($this->size <= 8) {
            return unpack('C', $data);
        } elseif ($this->size <= 16) {
            return unpack('S', $data);
        } elseif ($this->size <= 32) {
            return unpack('L', $data);
        } elseif ($this->size <= 64) {
            return unpack('Q', $data);
        }
      } else {
        if ($this->size <= 8) {
            return unpack('c', $data);
        } elseif ($this->size <= 16) {
            return unpack('s', $data);
        } elseif ($this->size <= 32) {
            return unpack('l', $data);
        } elseif ($this->size <= 64) {
            return unpack('q', $data);
        }
      }
      throw new \OverflowException('the size of ' . $this->size . 'is not supported');
    }

  }
