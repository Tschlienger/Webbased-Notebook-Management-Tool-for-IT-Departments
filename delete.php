<?php
include "db.php";
include "vars.php";

if (isset($_GET["id"])) {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = sprintf("DELETE FROM %s WHERE id=%s", $db_table, $_GET["id"]);

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    header("Location: $vars_urlbase?delete=success");
} else {
    header("Location: $vars_urlbase?delete=error");
}
?> 