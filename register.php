<?php
include "db.php";
include "vars.php";

if (isset($_GET["serial"]) and isset($_GET["os"])) {
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = sprintf("SELECT COUNT(id) AS 'id' FROM %s", $db_table);
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $incnumber = $row["id"];
        }
        echo "
            </tbody>
        </table>";
    }

    mysqli_close($conn);

    $incnumber += 1;
    $hostname = $vars_hostnameprefix . sprintf('%03d', $incnumber);
    $date = date('2017-05-10');

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = sprintf("INSERT INTO %s VALUES ('', '%s', '%s', '%s', '%s', '', '')", $db_table, $hostname, $_GET['serial'], $_GET['os'], $date);

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        $hostnamefile = fopen($vars_hostnamefile, "w") or die("Unable to open file");
        fwrite($hostnamefile, $hostname);
        fclose($hostnamefile);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

    header("Location: $vars_urlbase?register=success");
} else {
    header("Location: $vars_urlbase?register=error");
}
?> 