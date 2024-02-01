<?php
require_once("/laragon/www/Songs/config/setup.php");
require_once("/laragon/www/Songs/assets/classes/Song.php");


if (isset($_POST["submit"])) {

  $file_name = $_FILES['img']['name'];
  $temp_name = $_FILES['img']['tmp_name'];
  $folder = 'assets\images' . $file_name;
  // echo $file_name . "<br>";
  // echo $temp_name . "<br>";
  if (move_uploaded_file($temp_name, $folder)) {
    echo "image uploaded" . "<br>";
    $data = [
      "artist" => $_POST["artist"],
      "song" => $_POST["song"],
      "picture" => $file_name
    ];
    Song::insert($data);
  }
}

if (isset($_POST["delete"])) {

  Song::delete(
    ["id" => $_POST["id"]],
  );
}

if (isset($_POST["fav"])) {
  $conditions;
  if ($_POST["fav"] == 0) {
    $conditions = ["fav" => 1];
  } else {
    $conditions = ["fav" => 0];
  }
  Song::update($conditions, $_POST["id"]);
}

$songs = Song::select();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Songs</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <div class="add-area">
    <form method="POST" enctype="multipart/form-data">
      <div class="inputs">
        <div>
          <label>Artist Name:</label><input type="text" name="artist">
        </div>
        <div>
          <label>Song Name:</label><input type="text" name="song">
        </div>
        <div>
          <label>Image:</label><input type="file" name="img">
        </div>
      </div>
      <button name="submit" class="submit">Upload</button>
    </form>
  </div>

  <div class="song-area">
    <?php if (count($songs) > 0) {
      foreach ($songs as $song) { ?>

        <form method="POST" enctype="multipart/form-data">
          <div class="info">
            <div class="img">
              <img src="assets\images<?= $song['picture'] ?>">
            </div>
            <div class="song-info">
              <div class="song">
                <?= $song['song'] ?>
              </div>
              <div class="artist">
                <?= $song['artist'] ?>
              </div>
              <input type="hidden" name="id" value="<?= $song['id'] ?>">
              <input type="hidden" name="mark" value="<?= $song['fav'] ?>">
            </div>
          </div>
          <button class="fav" name="fav" value=<?= $song['fav'] ?>>
            <?= $song['fav'] == 0 ? "fav" : "un-fav" ?>
          </button>
          <button name="delete" value="Delete">Delete</button>
        </form>
      <?php }
    } ?>
  </div>
</body>

</html>