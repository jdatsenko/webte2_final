<?php
  $driver = 'pdo_mysql';
  $user = 'root';
  $password = 'root';
  $dbname = 'voting_system';
  $host = 'final-mysql-1';

  $connection = mysqli_connect($host, $user, $password, $dbname);

  if (!$connection) {
    die('Connection failed: '. mysqli_connect_error());
  }

