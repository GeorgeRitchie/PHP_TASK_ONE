<?php
class DB  
{
    private $host = 'localhost';
	private $database = 'OfficeRooms';
	private $user = 'root';
	private $password = '1234567';
    private $tableName = 'Rooms';

    private $link;

    public function __construct()
    {
        $this->link = mysqli_connect($this->host, $this->user, $this->password, $this->database) or die("Ошибка " . mysqli_error($this->link));
        
        if(!$this->isTableExists())
        {
            $this->CreateTable();
        }
    }

    private function isTableExists()
    {
        $query = mysqli_query($this->link, "SHOW TABLES FROM '$this->database' LIKE '$this->tableName';");
        $result = mysqli_fetch_array($query);

        return $result === false?false:true;
    }

    private function CreateTable()
    {
        $query = "CREATE Table $this->tableName
		(
		    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		    roomNumber INT NOT NULL,
		    residentName VARCHAR(200) NOT NULL,
            bookedFrom DATE,
            bookedTo Date
		)";
		$result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link)); 
    }

    public function CreateRoom($room, $roomNumber)
    {
        $query ="INSERT INTO $this->tableName VALUES(NULL, '$roomNumber','$room->residentName','$room->bookedFrom','$room->bookedTo')";
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link)); 
    }

    public function ReadAllRooms()
    {
        $query ="SELECT * FROM $this->tableName";
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link)); 
    
        if($result)
		{
		    while ($row = mysqli_fetch_row($result))
            {
                $room = new Room($row[2], $row[3], $row[4]);
		        $officeRooms[$row[1]] = $room;
		    }
		    
		    mysqli_free_result($result);

            return $officeRooms;
		}
    }

    public function UpdateRoom($room, $roomNumber)
    {
        $query ="UPDATE $this->tableName SET residentName='$room->residentName', bookedFrom='$room->bookedFrom', bookedTo='$room->bookedTo' WHERE roomNumber='$roomNumber'";
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link)); 
    }

    public function DeleteRoom($roomNumber)
    {
        $query ="DELETE FROM $this->tableName WHERE roomNumber = '$roomNumber'";
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link)); 
    }

    function __destruct()
    {
        mysqli_close($this->link);
    }
}
?>