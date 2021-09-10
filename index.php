<?php
    session_start();
    if(!isset($_SESSION["office"]))
    {
        include_once "TaskOne.php";
        $_SESSION["office"] = Office::getInstance();
    }

    if(isset($_POST["act"]))
    {
        $value = htmlentities($_POST["act"]);
        if($value === "Check Room")
        {
            header("Location: /TaskOne/CheckRoom.php");
        }
        elseif($value === "Book for new resident")
        {
            header("Location: /TaskOne/CheckRoom.php");
        }
        elseif($value === "See all booked rooms")
        {
            header("Location: /TaskOne/seeallbookedrooms.php");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<h2>Action</h2>
<form method="POST">
<p><input type="submit" name="act" value="Check Room"></p>
<p><input type="submit" name="act" value="Book for new resident"></p>
<p><input type="submit" name="act" value="See all booked rooms"></p>
</form>

</body>
</html>