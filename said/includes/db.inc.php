<?php
try
{
  include CONFIG;
  $pdo = new PDO($database, $databaseuser, $databasepass, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}
