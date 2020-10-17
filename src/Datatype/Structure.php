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
   * Description of Structure
   *
   * @author Guillaume de Lestanville <guillaume.delestanville@proximit.fr>
   */
  class Structure implements Type
  {
    private $attributes;

    public function __construct()
    {
      $this->attributes = array();
    }

    public function &get_attributes()
    {
      return $this->attributes;
    }

    /**
     * Add attribute
     * @param \guedel\AL\Declaration\VariableDecl $attr
     * @return \guedel\AL\Datatype\Structure
     */
    public function _attr_(\guedel\AL\Declaration\VariableDecl $attr): Structure
    {
      $this->attributes[$attr->get_name()] = $attr;
      return $this;
    }

    public function accept(\guedel\AL\Runtime\Visitor $visitor)
    {
      $visitor->visit_structure($this);
    }

    public function get_signature(): string
    {
      $ret = '{';
      $first = true;
      foreach($this->attributes as $attr)
      {
        if ($first) {
          $first = false;
        } else {
          $ret .= ';';
        }
        $ret .= $attr->get_signature();
      }
      return $ret . '}';
    }

  }
