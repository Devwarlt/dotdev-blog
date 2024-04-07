<?php

namespace php\dao;

use php\dao\db\MySQLDatabase;
use php\dao\db\SQLQuery;
use php\model\LoginModel;

final class LoginDAO
{
    private static LoginDAO $singleton;

    private function __construct() { }

    public function signIn(LoginModel $login): bool
    {
        $mysql = MySQLDatabase::getSingleton();
        return $mysql->insert(
            new SQLQuery(
                "INSERT INTO `users`(`username`, `password`, `email`, `level`)
                    VALUES (':username', SHA2(':password', 256), ':email', :level)",
                [
                    ":username" => $login->getUsername(),
                    ":password" => $login->getPassword(),
                    ":email" => $login->getEmail(),
                    ":level" => $login->getLevel()
                ]
            )
        );
    }

    public static function getSingleton(): LoginDAO
    {
        if (self::$singleton === null) self::$singleton = new LoginDAO();
        return self::$singleton;
    }

    public function signUp(LoginModel $login): ?LoginModel
    {
        $mysql = MySQLDatabase::getSingleton();
        $result = $mysql->select(
            new SQLQuery(
                "SELECT * FROM `users` WHERE `username` = ':username' AND `password` = SHA2(':password', 256)",
                [
                    ":username" => $login->getUsername(),
                    ":password" => $login->getPassword()
                ]
            )
        );

        if ($result === null) return null;

        $data = $result->fetch(\PDO::FETCH_OBJ);
        return new LoginModel(
            $data->id,
            $login->getUsername(),
            $login->getPassword(),
            $data->email,
            $data->level
        );
    }

    public function updateCredentials(LoginModel $login): bool
    {
        $mysql = MySQLDatabase::getSingleton();
        return $mysql->update(
            new SQLQuery(
                "UPDATE `users` SET `username` = ':username', `password` = SHA2(':password', 256),
                   `email` = ':email', `level` = :level WHERE `id` = :id",
                [
                    ":id" => $login->getId(),
                    ":username" => $login->getUsername(),
                    ":password" => $login->getPassword(),
                    ":email" => $login->getEmail(),
                    ":level" => $login->getLevel()
                ]
            )
        );
    }
}