<?php
include "db.php";
include "vars.php";

if (isset($_GET["id"]) and isset($_GET["customer"])) {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = sprintf("UPDATE %s SET invoice = '%s' WHERE id = %s", $db_table, $_GET["customer"], $_GET["id"]);

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    header("Location: $vars_urlbase?invoice=success");
} elseif (isset($_GET["id"]) and !isset($_GET["customer"])) {
    echo sprintf("<p><a href='?id=%s&customer=Holding'>Holding</a></p>", $_GET["id"]);
    echo sprintf("<p><a href='?id=%s&customer=Aarau'>Aarau</a></p>", $_GET["id"]);
}#} elseif ((!isset($_GET["id"]) and !isset(["customer"])) or (!isset($_GET["id"]) and isset(["customer"]))) {
#    header("Location: $vars_urlbase?invoice=error");
#}
?>