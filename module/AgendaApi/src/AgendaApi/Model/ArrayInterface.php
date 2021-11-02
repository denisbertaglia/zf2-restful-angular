<?php
namespace AgendaApi\Model;

interface ArrayInterface{
    public function getArrayCopy();
    public function exchangeArray(array $data);
}