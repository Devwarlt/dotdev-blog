<?php
	namespace php\dao\engine
	{

		use PDO;
		use PDOException;
		use PDOStatement;
		use php\controller\LoginController;

		define("DB_HOST", "localhost");
		define("DB_SCHEMA", "dotdev-db");
		define("DB_USER", "root");
		define("DB_PASSWORD", 'toor');

		final class MySQLDatabase
		{
			private static PDO $connection;
			private static $singleton;

			private function __construct(PDO $connection) { self::$connection = $connection; }

			public function update(SQLQuery $query) : bool { return self::dml($query->getQuery()); }

			private function dml(string $sql) : bool {
				try {
					$query = self::$connection->prepare($sql);
					if ($query->execute()) {
						return true;
					}
					else {
						if (LoginController::getSingleton()->fetchLogin()->getLevel() !== LOGIN_LEVEL_USER) {
							self::displayPDOError($query);
						}
						return false;
					}
				}
				catch (PDOException $e) {
					if (LoginController::getSingleton()->fetchLogin()->getLevel() !== LOGIN_LEVEL_USER) {
						self::displayPDOException($e);
					}
					return false;
				}
			}

			public static function getSingleton() : MySQLDatabase {
				try {
					if (self::$singleton === null) {
						$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_SCHEMA, DB_USER, DB_PASSWORD);
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						self::$singleton = new MySQLDatabase($pdo);
					}
				}
				catch (PDOException $e) {
					self::displayPDOException($e);
				}
				finally {
					return self::$singleton;
				}
			}

			private static function displayPDOException(PDOException $exception) : void {
				echo sprintf("
					<!DOCTYPE html>
					<html lang='pt' style='height: 100%%;'>
					<head>
					    <meta charset='UTF-8''>
					    <title>.DEV Blog - Error</title>
					    <link rel='stylesheet' href='../../../css/bootstrap.min.css'/>
					</head>
					<body style='height: 100%%;' class='h-100 row align-items-center  alert-light'>
					    <div class='card text-white bg-danger' style='padding: 4px; width: 100%%'>
					        <div class='text-warning card-header'>
					            <strong><span class='glyphicon glyphicon-alert' aria-hidden='true'></span>&nbsp;&nbsp;
					            <u>Internal connection exception!</u></strong></div>
					        <div class='card-body'>
					            <h5>PDOException::getMessage():</h5>
					            <p><small><strong>&blacktriangleright;&nbsp;Message:</strong>
					            <code class='text-warning bg-dark border-warning rounded'>%s</code></small></p>
					        </div>
					        <div class='card-footer'>
					            <h5>Stack trace:</h5>
					            <pre class='text-warning bg-dark border-warning rounded'>%s</pre>
					        </div>
					    </div>
					    <hr/>
					    <script type='text/javascript' src='../../../js/bootstrap.min.js'></script>
					    <script type='text/javascript' src='../../../js/bootstrap.bundle.min.js'></script>
					</body>
					</html>",
					$exception->getMessage(),
					json_encode($exception->getTrace(), JSON_PRETTY_PRINT));
			}

			private static function displayPDOError(PDOStatement $query) : void {
				echo sprintf("<hr/>
					<!DOCTYPE html>
					<html lang='pt' style='height: 100%%;'>
					<head>
					    <meta charset='UTF-8''>
					    <title>.DEV Blog - Error</title>
					</head>
					<body style='height: 100%%;' class='h-100 row align-items-center  alert-light'>
					    <div class='card text-white bg-danger' style='padding: 4px; width: 100%%'>
					        <div class='text-warning card-header'>
					            <strong><span class='glyphicon glyphicon-alert' aria-hidden='true'></span>&nbsp;&nbsp;
					            <u>Query error detected!</u></strong></div>
					        <div class='card-body'>
					            <h5 style='margin: 0'>Query:</h5>&nbsp;
					            <p class='font-monospace text-warning bg-dark border-warning rounded' style='margin: 0'>
					                &nbsp;%s&nbsp;
					            </p>            
					        </div>
					        <div class='card-footer'>
					            <h5><u>PDO::errorInfo()</u></h5>
					            <p style='margin: 0'><small><strong>&blacktriangleright;&nbsp;SQLSTATE Error Code:</strong> %s</small></p>
					            <p style='margin: 0'><small><strong>&blacktriangleright;&nbsp;Driver-specific Error Code:</strong> %s</small></p>
					            <p style='margin: 0'><small><strong>&blacktriangleright;&nbsp;Driver-specific Error Message:</strong> %s</small></p>
					        </div>
					    </div>
					</body>
					</html><hr/>",
					preg_replace('/\s+/', ' ', $query->queryString),
					$query->errorInfo()[0] ?? "empty",
					$query->errorInfo()[1] ?? "empty",
					$query->errorInfo()[2] ?? "empty");
			}

			public function delete(SQLQuery $query) : bool { return self::dml($query->getQuery()); }

			public function insert(SQLQuery $query) : bool { return self::dml($query->getQuery()); }

			public function select(SQLQuery $query) : ?PDOStatement { return self::dql($query->getQuery()); }

			private function dql(string $sql) : ?PDOStatement {
				try {
					$query = self::$connection->query($sql);
					if ($query->execute() && $query->rowCount() > 0) {
						return $query;
					}
					else {
						if (LoginController::getSingleton()->fetchLogin()->getLevel() !== LOGIN_LEVEL_USER) {
							$this->displayPDOError($query);
						}
						return null;
					}
				}
				catch (PDOException $e) {
					if (LoginController::getSingleton()->fetchLogin()->getLevel() !== LOGIN_LEVEL_USER) {
						self::displayPDOException($e);
					}
					return null;
				}
			}
		}
	}
