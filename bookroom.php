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

$roomsNumbers = [];
for ($i=1; $i <= 5; $i++) 
{ 
    if($office->IsRoomEmpty($i))
        $roomsNumbers[$i - 1] = $i;
}

if(count($roomsNumbers) > 0)
{
    echo "<h4>Empty rooms number</h4>";
    foreach ($roomsNumbers as  $id) {
        echo $id . " ";
    }

    echo "<br/>";
?>
<h2>Booking room</h2>
<form action="bookingoperator.php" method="POST">
<p>Number of room<br/><input type="number" required name="roomNumber" value="" max="5" min="1"></p>
<p>Resident's name<br/><input type="text" required name="residentName"></p>
<p>Resident's phone number<br/><input type="tel" minlength="9" placeholder="XX-XXX-XXXX" required pattern="[0-9]{2}-[0-9]{3}-[0-9]{4}" name="phoneNumber"></p>
<p>Resident's eAddress<br/><input type="email" required name="eAddress"></p>
<p>Booking from date <br/><input type="date" required name="bookingFrom"></p>
<p>Booking to date <br/><input type="date" required name="bookingTo"></p>
<p><input type="submit" value="Book"></p>
</form>

<?php
}
else
{
    echo "ALL ROOMS ARE BOOKED";
}

?>

<form action="index.php" method="POST">
<p><input type="submit" value="Go to main page"></p>
</form>

</body>
</html>