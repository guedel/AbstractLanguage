<?php

  /*
   * The MIT License
   *
   * Copyright 2018 Guillaume de Lestanville <guillaume.delestanville@proximit.fr>.
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

  namespace guedel\AL\Datatype;

  /**
   * IEEE presentation of floatting number.
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class Float extends Primary
  {
    private $double;

    public function __construct(bool $is_double = false)
    {
      $this->double = $is_double;
    }

    public function to_binary_data($value): string
    {
      if ($this->double) {
        return pack('d', $value);
      }
      return pack('f', $value);
    }

    public function get_name(): string
    {
      if ($this->double) {
        return 'double';
      }
      return 'float';
    }

    public function get_full_name()
    {
      return parent::get_full_name() . '.' . $this->get_name();
    }

    public function from_binary_data($data)
    {
      if ($this->double) {
        return unpack('d', $data);
      }
      return unpack('f', $data);
    }

  }