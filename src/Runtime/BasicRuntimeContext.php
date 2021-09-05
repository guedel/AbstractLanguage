<?php

/*
 * The MIT License
 *
 * Copyright 2021 Guedel <guedel87@live.fr>.
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

namespace Guedel\AL\Runtime;

use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Declaration\VariableDecl;

/**
 * Description of BasicRuntimeContext
 *
 * @author Guedel <guedel87@live.fr>
 */
final class BasicRuntimeContext
{
  private $name;
  private ?BasicRuntimeContext $parent = null;
  private $types = [];

  /**
   *
   * @var VariableDecl[]
   */
  private $variables = [];
  private $functions = [];
  private $procedures = [];

  public function __construct(?BasicRuntimeContext $parent = null, string $name = null)
  {
    $this->name = $name;
    $this->parent = $parent;
  }

  public function getParent(): ?BasicRuntimeContext
  {
    return $this->parent;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  /**
   * Search a variable declaration in current scope.
   * @param string $name
   * @return VariableDecl|null
   */
  public function findVariable(string $name): ?VariableDecl
  {
    return $this->find($name, "variables", "findVariable");
  }

  public function addVariable(VariableDecl $decl): BasicRuntimeContext
  {
    $name = $decl->getName();
    if (isset($this->variables[$name])) {
      throw new Exception("Variable $name already defined in this scope");
    }
    $this->variables[$name] = $decl;
    return $this;
  }

  public function findFunction(string $name): ?FunctionDecl
  {
    return $this->find($name, "functions", "findFunction");
  }

  public function addFunction(FunctionDecl $decl): BasicRuntimeContext
  {
    $name = $decl->getName();
    if (isset($this->functions[$name])) {
      throw new Exception("Function $name already defined in this scope");
    }
    $this->functions[$name] = $decl;
    return $this;
  }

  public function findProcedure(string $name): ?ProcedureDecl
  {
    return $this->find($name, "procedures", "findProcedure");
  }

  public function addProcedure(ProcedureDecl $decl): BasicRuntimeContext
  {
    $name = $decl->getName();
    if (isset($this->procedures[$name])) {
      throw new Exception("Procedure $name already defined in this scope");
    }
    $this->procedures[$name] = $decl;
    return $this;
  }

  public function findType(string $name): ?TypeDecl
  {
    return $this->find($name, "types", "findType");
  }

  public function addType(TypeDecl $decl)
  {
    $name = $decl->getName();
    if (isset($this->types[$name])) {
      throw new Exception("Type $name already defined in this scope");
    }
    $this->types[$name] = $decl;
    return $this;
  }

  protected function find(string $name, $collectionName, string $funcToCall)
  {
    if (isset($this->$collectionName[$name])) {
      return $this->$collectionName[$name];
    }
    if ($this->parent) {
      return $this->parent->$funcToCall($name);
    }
    return null;
  }
}
