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

  namespace Guedel\AL\Declaration;

  /**
   * Definition of a function or procedure parameter
   *
   * @author Guedel <guedel87@live.fr>
   */
  class Parameter extends VariableDecl
  {
    const INPUT = 'IN';
    const OUTPUT = 'OUT';
    const INOUT = 'INOUT';
    const RET = 'RETURN';

    private $direction;

    public function __construct(string $name, string $direction, \Guedel\AL\Datatype\Type $type = null)
    {
      parent::__construct($name, $type);
      $this->direction = $direction;
    }

    public function get_direction() : string
    {
      return $this->direction;
    }

    public function accept(\Guedel\AL\Runtime\Visitor $visitor)
    {
      return $visitor->declare_parameter($this);
    }

  }
