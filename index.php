<?php
include "db.php";
include "vars.php";

if (isset($_GET["register"])) {
    if ($_GET["register"] == "success") {
        echo "<p>Gerät wurde erfolgreich registriert!</p>";
    } elseif ($_GET["register"] == "error") {
        echo "<p>Beim Registrieren des Geräts ist ein Fehler aufgetreten!</p>";
    }
}

if (isset($_GET["delete"])) {
    if ($_GET["delete"] == "success") {
        echo "<p>Gerät wurde erfolgreich gelöscht!</p>";
    } elseif ($_GET["delete"] == "error") {
        echo "<p>Beim Löschen des Geräts ist ein Fehler aufgetreten!</p>";
    }
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = sprintf("SELECT id, hostname, serial, os, registered, invoice, owner FROM %s", $db_table);
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "
    <table border='1px'>
        <thead>
            <td>Hostname</td>
            <td>Seriennummer</td>
            <td>Betriebssystem</td>
            <td>Registrierdatum</td>
            <td>Aktionen</td>
        </thead>
        <tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["hostname"]. "</td><td>" . $row["serial"] . "</td><td>" . $row["os"]. "</td><td>" . date("d.m.Y", strtotime($row["registered"])) . "</td><td>";
        echo "<a href='" . $vars_urlbase . "/delete?id=" . $row["id"] . "'>Löschen</a>";
        if ($row["invoice"] == "") {
            echo " <a href='" . $vars_urlbase . "/invoice?id=" . $row["id"] . "'>Verrechnen</a>";
        }
        if ($row["invoice"] != "" and $row["owner"] == "") {
            echo " <a href='" . $vars_urlbase . "/owner?id=" . $row["id"] . "'>Besitzer</a>";
        }
        echo "</td></tr>";
    }
    echo "
        </tbody>
    </table>";
} else {
    echo "Keine Notebooks registriert";
}

mysqli_close($conn);
?>