<?php
/**
 * @var PDO $pdo
 */

require_once("/laragon/www/Songs/assets/classes/DB.php");

class Song
{

  private static $table = "song";
  private static $columns = ["id", "artist", "song", "picture", "fav"];


  public static function select(): array
  {
    // $stmt = DB::$pdo->prepare("SELECT * FROM songs");
    $stmt = DB::$pdo->prepare("SELECT " . implode(",", self::$columns) . " FROM  " . self::$table . "");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  }

  public static function insert(array $data): bool
  {
    $keys = array_keys($data);
    $placeHolders = array_map(fn(string $key): string => ":$key", $keys);
    $stmt = DB::$pdo->prepare(" INSERT INTO " . self::$table . " (" . implode(", ", $keys) . ")
    VALUES (" . implode(", ", $placeHolders) . ")
    ");
    return $stmt->execute($data);
  }
  public static function delete(array $conditions): bool
  {
    $keys = array_keys($conditions);
    $placeHolders = array_map(fn(string $key): string => "$key = :$key", $keys);
    $stmt = DB::$pdo->prepare(" DELETE FROM " . self::$table . "
    where  " . implode(",", $placeHolders) . "
    ");
    return $stmt->execute($conditions);
  }

  public static function update(array $conditions, int $id): bool
  {
    $keys = array_keys($conditions);
    $placeHolders = array_map(fn(string $key): string => "$key = :$key", $keys);
    $stmt = DB::$pdo->prepare(" UPDATE " . self::$table . " 
    SET " . implode(", ", $placeHolders) . " 
    WHERE id = $id
    ");
    return $stmt->execute($conditions);
  }
}