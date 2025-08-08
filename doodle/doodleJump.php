<?php
session_start();

if($_SERVER['HTTP_HOST'] == "127.0.0.1") {
    $mysqli = new mysqli("localhost", "root", "", "mca");
} else {
    $mysqli = new mysqli("195.35.59.14", "u121755072_adu", "fH:=aeo*l^D2", "u121755072_adudb");
}
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$scoreRows = [];
$sql = "SELECT u.username AS username, s.score AS score, s.timestamp AS timestamp
        FROM scores s
        JOIN users u ON s.id = u.id
        WHERE s.game = 'doodleJump'
        ORDER BY s.score DESC, s.timestamp ASC
        LIMIT 20";
if ($result = $mysqli->query($sql)) {
    $scoreRows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doodle Jump</title>
</head>
<body>
    <canvas width="670px" height="670px" style="background-color: lightblue;"></canvas>

    <div style="float:right; margin-right: 40px; margin-top: 20px;">
        <h1>Score</h1>
        <div>
            <?php
            if (isset($_SESSION['UserID']) && $_SESSION['UserID'] !== '') {
                echo "You are Logged in as " . htmlspecialchars($_SESSION['UserID']);
            } else {
                echo "Not logged in";
            }
            ?>
        </div>
        <table style="border-color: black; border-style: solid; border-width: 3px;">
            <tr><th>Player</th><th>Score</th><th>Time</th></tr>
            <?php foreach ($scoreRows as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['score']); ?></td>
                    <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <script src="doodleJump.js" defer></script>
</body>
</html>