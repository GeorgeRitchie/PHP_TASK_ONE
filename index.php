<?php
    // session_start();
    // session_destroy();
    session_start();
    
    if(!isset($_SESSION["office"]))
    {
        include_once "TaskOne.php";
        
        $_SESSION["office"] = serialize(new Office());
    }

    if(isset($_POST["act"]))
    {
        $value = htmlentities($_POST["act"]);
        if($value === "Check Room")
        {
            header("Location: /TaskOne/PHP_TASK_ONE/CheckRoom.php");
        }
        elseif($value === "Book for new resident")
        {
            header("Location: /TaskOne/PHP_TASK_ONE/bookroom.php");
        }
        elseif($value === "See all booked rooms")
        {
            header("Location: /TaskOne/PHP_TASK_ONE/seeallbookedrooms.php");
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