<?php

namespace AgendaApi\Model;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

abstract class AbstractModel   {

    abstract public function toArray();
    
    abstract public function exchangeArray(array $data);

}
