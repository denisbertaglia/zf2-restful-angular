<?php

namespace AgendaApi\Model;

interface IdModel {
    
    /**
     * {@inheritDoc}
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);
}