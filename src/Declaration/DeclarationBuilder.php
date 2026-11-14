<?php

namespace Guedel\AL\Declaration;

class DeclarationBuilder extends Builder
{
  public function stmtType(string $name, Datatype\Type $definition): Builder
  {
    $this->statements->add(new Declaration\TypeDecl($name, $definition));
    return $this;
  }

  public function stmtProcedure(string $name, Declaration\ParametersList $parameters = null): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\ProcedureDecl($name, $parameters, $ret->statements));
    return $ret;
  }

  public function stmtFunction(
      string $name,
      Type $return_type,
      Declaration\ParametersList $parameters = null
  ): Builder {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\FunctionDecl($name, $return_type, $parameters, $ret->statements));
    return $ret;
  }

  public function stmtModule(string $name): Builder
  {
    $ret = $this->stmtBegin();
    $this->statements->add(new Declaration\Module($name, $ret->statements));
    return $ret;
  }
}
