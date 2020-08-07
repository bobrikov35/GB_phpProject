<?php

namespace app\entities;


/**
 * Class Entity
 * @package app\entities
 */
abstract class Entity
{

    /**
     * С В О Й С Т В А
     */

    protected int $id = 0;


    /**
     * А Б С Т Р А К Т Н Ы Е   Ф У Н К Ц И И
     */

    /**
     * @return array
     */
    abstract public function getVars(): array;


    /**
     * S E T T E R ' Ы
     */

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = !empty($id) and is_numeric($id) ? (int)$id : 0;
    }


    /**
     * G E T T E R ' Ы
     */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
