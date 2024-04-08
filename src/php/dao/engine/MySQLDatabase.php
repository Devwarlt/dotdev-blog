<?php

namespace php\dao\engine;

use PDO;
use PDOException;
use PDOStatement;

define("DB_HOST", "localhost");
define("DB_SCHEMA", "dotdev-db");
define("DB_USER", "dbadmin");
define("DB_PASSWORD", 'toor');

final class MySQLDatabase
{
    private static PDO $connection;
    private static $singleton;

    private function __construct(PDO $connection) { self::$connection = $connection; }

    public static function getSingleton(): MySQLDatabase
    {
        try {
            if (self::$singleton === null) {
                $pdo = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA,
                    DB_USER,
                    DB_PASSWORD
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$singleton = new MySQLDatabase($pdo);
            }
        }
        catch (PDOException $e) { self::displayPDOException($e); }
        finally { return self::$singleton; }
    }

    public function update(SQLQuery $query): bool { return $this->dml($query->getQuery()); }

    private function dml(string $sql): bool
    {
        $query = self::$connection->prepare($sql);
        if ($query->execute()) return true;
        else {
            self::displayPDOError($query);
            return false;
        }
    }

    private static function displayPDOError(PDOStatement $query): void
    {
        echo "
<!DOCTYPE html>
<html lang='pt' style='height: 100%;'>
<head>
    <meta charset='UTF-8''>
    <title>.DEV Blog - Error</title>
    <link rel='stylesheet' href='../../../css/bootstrap.min.css'/>
</head>
<body style='height: 100%;' class='h-100 row align-items-center  alert-light'>
    <div class='card text-white bg-danger' style='padding: 4px; width: 100%'>
        <div class='text-warning card-header'>
            <strong><span class='glyphicon glyphicon-alert' aria-hidden='true'></span>&nbsp;&nbsp;
            <u>Query error detected!</u></strong></div>
        <div class='card-body'>
            <h5>Query:</h5>&nbsp;
            <pre class='text-warning bg-dark border-warning rounded'>
                &nbsp;" . $query->queryString . "&nbsp;
            </pre>            
        </div>
        <div class='card-footer'>
            <h5>PDO::errorInfo():</h5>
            <p><small><strong>&blacktriangleright;&nbsp;SQLSTATE Error Code:</strong> "
                . $query->errorInfo()[0] . "</small></p>
            <p><small><strong>&blacktriangleright;&nbsp;Driver-specific Error Code:</strong> "
                . $query->errorInfo()[1] . "</small></p>
            <p><small><strong>&blacktriangleright;&nbsp;Driver-specific Error Message:</strong> "
                . $query->errorInfo()[2] . "</small></p>
        </div>
    </div>
    <hr/>
    <script type='text/javascript' src='../../../js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../../../js/bootstrap.bundle.min.js'></script>
</body>
</html>";
    }

    private static function displayPDOException(PDOException $exception): void
    {
        echo "
<!DOCTYPE html>
<html lang='pt' style='height: 100%;'>
<head>
    <meta charset='UTF-8''>
    <title>.DEV Blog - Error</title>
    <link rel='stylesheet' href='../../../css/bootstrap.min.css'/>
</head>
<body style='height: 100%;' class='h-100 row align-items-center  alert-light'>
    <div class='card text-white bg-danger' style='padding: 4px; width: 100%'>
        <div class='text-warning card-header'>
            <strong><span class='glyphicon glyphicon-alert' aria-hidden='true'></span>&nbsp;&nbsp;
            <u>Internal connection exception!</u></strong></div>
        <div class='card-body'>
            <h5>PDOException::getMessage():</h5>
            <p><small><strong>&blacktriangleright;&nbsp;Message:</strong>
            <code class='text-warning bg-dark border-warning rounded'>"
            . $exception->getMessage() . "</code></small></p>
        </div>
        <div class='card-footer'>
            <h5>Stack trace:</h5>
            <pre class='text-warning bg-dark border-warning rounded'>"
            . json_encode($exception->getTrace(), JSON_PRETTY_PRINT) .
            "</pre>
        </div>
    </div>
    <hr/>
    <script type='text/javascript' src='../../../js/bootstrap.min.js'></script>
    <script type='text/javascript' src='../../../js/bootstrap.bundle.min.js'></script>
</body>
</html>";
    }

    public function delete(SQLQuery $query): bool { return $this->dml($query->getQuery()); }

    public function insert(SQLQuery $query): bool { return $this->dml($query->getQuery()); }

    public function select(SQLQuery $query): ?PDOStatement { return $this->dql($query->getQuery()); }

    private function dql(string $sql): ?PDOStatement
    {
        $query = self::$connection->query($sql);
        if (($success = $query->execute()) && $query->rowCount() > 0) return $query;
        if (!$success) $this->displayPDOError($query);
        return null;
    }
}