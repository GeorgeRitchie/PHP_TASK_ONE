<?
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<h2>Checking room</h2>
<form method="POST">
<p>Number of room<br/><input type="number" name="roomNumber" value="1" max="5" min="1"></p>
<p>Booking from date <br/><input type="date" name="bookingFrom"></p>
<p><input type="submit" value="Check"></p>
</form>

<?php
if(isset($_POST["roomNumber"]) && isset($_POST["bookingFrom"]))
{
    include_once "TaskOne.php";
    if(!isset($_SESSION["office"]))
    {
        throw new Exception("WHAT FUCK IS GOING");
    }
    $office = $_SESSION["office"];
    $roomNumber = $_POST["roomNumber"];
    $bookingFrom = $_POST["bookingFrom"];

    if($office->TEMP === $roomNumber)
    echo "HHHHHHHHHHH $office->TEMP";
    else
    $office->TEMP = $roomNumber;

    if($office->IsRoomEmptyInTime($roomNumber, $bookingFrom))
    {
        echo "<p>Room $roomNumber is empty</p>";
    }
    else
    {
        echo "<p>Room $roomNumber is booked by<br/>" . $office->GetInfoAboutBookerInRoom($roomNumber) . "</p>";
    }
}
?>

<form action="index.php" method="POST">
<p><input type="submit" value="Go to main page"></p>
</form>

</body>
</html>