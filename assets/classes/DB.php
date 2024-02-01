<?php

class DB
{

  private static string $server = "localhost";
  private static string $username = "root";
  private static string $password = "";
  private static string $database = "songs";

  public static PDO $pdo;
  public static function init()
  {
    try {
      self::$pdo = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$database, self::$username, self::$password);
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (Throwable $th) {
      echo $th->getMessage();
    }
  }

}