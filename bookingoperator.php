<?
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<?php 

include_once "TaskOne.php";

$office = unserialize($_SESSION["office"]);

if(isset($_POST["notify"]))
{
    $residentBooked = unserialize($_SESSION["resident"]);
    $roomNumberBooked = unserialize($_SESSION["roomNumber"]);
    $office->Notify($residentBooked, $roomNumberBooked);
}
elseif (isset($_POST["roomNumber"]) && isset($_POST["residentName"]) && isset($_POST["phoneNumber"]) && 
isset($_POST["eAddress"]) && isset($_POST["bookingFrom"]) && isset($_POST["bookingTo"]))
{
    $resident = new Resident();
    $resident->bookingFrom = $_POST["bookingFrom"];
    $resident->bookingTo = $_POST["bookingTo"];
    $resident->residentName = $_POST["residentName"];
    $resident->phoneNubmer = $_POST["phoneNumber"];
    $resident->eAddress = $_POST["eAddress"];

    $roomNumber = $_POST["roomNumber"];

    $_SESSION["resident"] = serialize($resident);
    $_SESSION["roomNumber"] = serialize($roomNumber);

    try {
        $office->Book($resident, $roomNumber);

        $_SESSION["office"] = serialize($office);

        echo "<h3>Room $roomNumber is successfully booked by resident $resident->residentName</h3>";
?>

<form method="POST">
<p><input type="submit" name="notify" value="Notify resident"></p>
</form>

<?php

    } catch (\Throwable $th) {
        echo "<h4>Booking is failed</h4>";
        echo $th->getMessage();
    }
}
?>

<form action="bookroom.php" method="POST">
<p><input type="submit" value="Go back"></p>
</form>
<form action="index.php" method="POST">
<p><input type="submit" value="Go to main page"></p>
</form>

</body>
</html>