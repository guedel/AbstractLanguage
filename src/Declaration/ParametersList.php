<?php

/*
 * This file is part of AbstractLanguage library.
 *
 * (c) Guedel <guedel87@live.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Guedel\AL\Declaration;

/**
 * Description of ParemetersList
 *
 * @author Guedel <guedel87@live.fr>
 */
class ParametersList implements \IteratorAggregate, \Countable, \ArrayAccess
{
    private $parameters;

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = $parameters;
    }

    public function add(Parameter $param)
    {
        $this->parameters[] = $param;
        return $this;
    }

    /**
     * @return \Iterator<Parameter>
     */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->parameters);
    }

    public function count(): int
    {
        return count($this->parameters);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->parameters[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->parameters[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->parameters[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->parameters[$offset]);
    }
}
