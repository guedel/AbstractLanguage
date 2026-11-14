<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Runtime;

use Guedel\AL\Declaration\FunctionDecl;
use Guedel\AL\Declaration\ProcedureDecl;
use Guedel\AL\Declaration\TypeDecl;
use Guedel\AL\Declaration\VariableDecl;
use Guedel\AL\Expression\ExpressionList;
use Guedel\AL\Expression\Value;

/**
 * Store context for basic runtime visitor
 *
 * @author Guedel <guedel87@live.fr>
 */
final class BasicRuntimeContext
{
    private $name;
    private ?BasicRuntimeContext $parent = null;
    private $types = [];
    private $returnValues = [];
    private bool $returnRequest = false;

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
            throw new \Exception("Variable $name already defined in this scope");
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
            throw new \Exception("Function $name already defined in this scope");
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
            throw new \Exception("Procedure $name already defined in this scope");
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
            throw new \Exception("Type $name already defined in this scope");
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

    public function setReturnRequest(bool $enable = true, ...$values)
    {
        $this->returnRequest = $enable;
        $this->returnValues = $values;
    }

    public function getReturnValues(): array
    {
        return $this->returnValues;
    }

    public function isReturnRequest(): bool
    {
        return $this->returnRequest;
    }
}
