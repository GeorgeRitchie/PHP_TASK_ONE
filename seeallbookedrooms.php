<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<?php
    session_start();
    include_once "TaskOne.php";

    $office = $_SESSION["office"];

    for($i = 1; $i<=5 ; $i++)
    {
        if($office->IsRoomEmpty($i))
        {
            echo "<p>Room $i is empty</p>";
        }
        else
        {
            echo "<p>Room $i is booked by<br/>" . $office->GetInfoAboutBookerInRoom($i) . "</p>";
        }
    }

?>

<form action="index.php" method="POST">
<p><input type="submit" value="Go to main page"></p>
</form>

</body>
</html>