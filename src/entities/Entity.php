<?php

namespace app\entities;


/**
 * Class Entity
 * @package app\entities
 */
abstract class Entity
{

    protected int $id = 0;


    /**
     * @return array
     */
    abstract public function getVars(): array;


    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = 0;
        if (!empty($id) and is_numeric($id)) {
            $this->id = (int)$id;
        }
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
