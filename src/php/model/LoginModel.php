<?php

namespace php\model;

final class LoginModel
{
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private int $level;

    public function __construct(int $id, string $username, string $password, string $email, int $level)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->level = $level;
    }

    public function getId(): int { return $this->id; }

    public function getUsername(): string { return $this->username; }

    public function getPassword(): string { return $this->password; }

    public function getEmail(): string { return $this->email; }

    public function getLevel(): int { return $this->level; }
}