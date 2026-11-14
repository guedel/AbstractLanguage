<?php

namespace Guedel\AL\Datatype;

trait DatatypeBuilder
{
  public function enumType(string ...$symbols): Enumeration
  {
    return new Enumeration(...$symbols);
  }

  public function arrayType($min, $max, Type $type)
  {
    return new ArrayOf($type, $min, $max);
  }

  public function stringType($len = null)
  {
    return new StringOfChars($len);
  }
}
