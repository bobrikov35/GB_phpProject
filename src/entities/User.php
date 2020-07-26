<?php

namespace app\entities;


class User extends Entity
{

    private string $name = '';
    private string $email = '';
    private string $password = '';
    private bool $admin = false;


    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = '';
        if (!empty($name)) {
            $this->name = (string)$name;
        }
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = '';
        if (!empty($email)) {
            $this->email = (string)$email;
        }
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = '';
        if (!empty($password)) {
            $this->password = (string)$password;
        }
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin): void
    {
        $this->admin = !empty($admin) and $admin;
    }


    /**
     * @return array
     */
    public function getVars(): array
    {
        $vars = get_object_vars($this);
        unset($vars['id']);
        return $vars;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function getAdmin(): bool
    {
        return $this->admin;
    }

}
