<?php
session_start();


if($_SERVER['HTTP_HOST'] == "127.0.0.1") {
    $mysqli = new mysqli("localhost", "root", "", "mca");
} else {
    $mysqli = new mysqli("195.35.59.14", "u121755072_adu", "fH:=aeo*l^D2", "u121755072_adudb");
}
if ($mysqli->connect_error) {
    http_response_code(500);
    echo "DB connection failed";
    exit;
}

$uname = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : '';
$uscore = isset($_POST["score"]) ? intval($_POST["score"]) : 0;
$game = isset($_POST["game"]) ? $_POST["game"] : '';

if ($uname !== '' && $game !== '' && $uscore >= 0) {
    $sql = "INSERT INTO scores (game, id, score, timestamp) VALUES (?, (SELECT id FROM users WHERE username = ?), ?, NOW())";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('ssi', $game, $uname, $uscore);
        $stmt->execute();
        $stmt->close();
    }
}

echo "OK";

?>

