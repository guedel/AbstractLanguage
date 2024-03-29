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
   * Description of ArrayOf
   *
   * @author Guedel <guedel87@live.fr>
   */
class ArrayOf implements Type
{
  private Type $type;
  private ?int $lowerbound;
  private ?int $upperbound;

  public function __construct(Type $type, ?int $lowerbound = null, ?int $upperbound = null)
  {
      $this->type = $type;
      $this->lowerbound = $lowerbound;
      $this->upperbound = $upperbound;
  }

  public function getType(): Type
  {
      return $this->type;
  }

  public function getLowerbound(): ?int
  {
      return $this->lowerbound;
  }

  public function getUpperbound(): ?int
  {
      return $this->upperbound;
  }

  public function accept(\Guedel\AL\Runtime\Visitor $visitor)
  {
      $visitor->visitArrayof($this);
  }

  public function getSignature(): string
  {
      $ret = 'array[';
      $ret .= $this->lowerbound;
      $ret .= ',';
      $ret .= $this->upperbound;
      $ret .= ']:' . $this->type->getSignature();
      return $ret;
  }
}
