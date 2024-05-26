<?php

namespace php\dao\engine;

final class SQLQuery
{
    private ?array $params;
    private string $sql;

    public function __construct(string $sql, array $params = null)
    {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function getQuery(): string
    {
        if ($this->params !== null)
            $this->sql = self::replaceArray($this->sql, $this->params);
        return $this->sql;
    }

    private static function replaceArray(string $value, array $array): string
    {
        foreach ($array as $innerKey => $innerValue)
            $value = str_replace($innerKey, $innerValue, $value);
        return $value;
    }
}