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
   * Description of String
   *
   * @author Guedel <guedel87@live.fr>
   */
class StringOfChars implements Type, Convertible
{
    private $length;

  public function __construct($length = null)
  {
      $this->length = $length;
  }

  public function getLength(): int
  {
      return $this->length;
  }

  public function accept(\Guedel\AL\Runtime\Visitor $visitor)
  {
      $visitor->visitString($this);
  }

  public function fromBinaryData($data)
  {
      return unpack('a', $data);
  }

  public function toBinaryData($value): string
  {
      return pack('a', $value);
  }

  public function getSignature(): string
  {
      $ret = 'STRING';
    if ($this->length !== null) {
        $ret .= '*' . $this->length;
    }
      return $ret;
  }
}
