<?php
  require __DIR__ . '/vendor/autoload.php';

  $driver = 'pdo_mysql';
  $user = 'root';
  $password = 'root';
  $dbname = 'voting_system';
  $host = 'webte_final-mysql-1';

  $connection = mysqli_connect($host, $user, $password, $dbname);

  $connectionString = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4';

  $auth = new \Delight\Auth\Auth(new \PDO($connectionString , $user, $password));

  if (!$connection) {
    die('Connection failed: '. mysqli_connect_error());
  }

