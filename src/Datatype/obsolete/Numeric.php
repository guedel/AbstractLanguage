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
   * Description of Numeric
   *
   * @author Guedel <guedel87@live.fr>
   */
  class Numeric extends Primary
  {
    private $size;
    private $precision;
    
    public function get_name(): string
    {
      return 'numeric';
    }

    public function get_full_name()
    {
      return parent::get_full_name() . '.' . $this->get_name();
    }

    public static function get_type(): BaseTye
    {
      return new Numeric();
    }

    public function to_binary_data($value): string
    {
      return pack('d', $value);
    }

    public function from_binary_data($data)
    {
      return unpack('d', $data);
    }

  }
