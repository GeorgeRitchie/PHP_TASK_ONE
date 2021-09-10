<?php

session_start();

class Room 
{
    function __construct($residentName, $bookedFrom, $bookedTo)
    {
        $this->residentName = $residentName;
        $this->bookedFrom = $bookedFrom;
        $this->bookedTo=$bookedTo;
    }

    public $residentName;
    public $bookedFrom;
    public $bookedTo;
}

class Resident
{
    public $residentName;
    public $phoneNubmer;
    public $eAddress;
    public $bookingFrom;
    public $bookingTo;
}

require_once "DB.php";

class Office
{
    private const maxRooms = 5;
    private $rooms = [null];

    public $TEMP;

    public function __construct()
    {
        $dataBase = new DB();

        $this->rooms = $dataBase->ReadAllRooms();

        /*$this->rooms[0] = new Room("Tom", time(), time());
        $this->rooms[1] = new Room("Tom", time(), time());
        $this->rooms[2] = new Room("Tom", time(), time());
        $this->rooms[3] = new Room("Tom", time(), time());
        $this->rooms[4] = new Room("Tom", time(), time()); */
    }
    
    public function IsRoomEmpty($roomNumber = 1)
    {
        $today = date("Y-m-d");

        if(isset($this->rooms[$roomNumber - 1]))
        {
            if($this->rooms[$roomNumber - 1]->bookedTo < $today)
            {
                $this->rooms[$roomNumber - 1] = null;
                
                $dataBase = new DB();
                $dataBase->DeleteRoom($roomNumber-1);

                $_SESSION["office"] = serialize($this);
            }
        }

        return !isset($this->rooms[$roomNumber - 1]) || $this->rooms[$roomNumber - 1] === null;
    }

    public function IsRoomEmptyInTime($roomNumber = 1, $bookindFrom = 0)
    {
        if($this->IsRoomEmpty($roomNumber))
        {
            return true;
        }
        else
        {
            $lookindRoom = $this->rooms[$roomNumber - 1];
            if($lookindRoom->bookedTo < $bookindFrom)
                return true;
            else
                return false;
        }
    }

    public function Book($newResident, $roomNumber)
    {
        if($roomNumber >= Office::maxRooms)
        {
            throw new Exception("There is only 5 rooms in Office.");
        }
        elseif($this->IsRoomEmpty($roomNumber))
        {
            $this->rooms[$roomNumber - 1]= new Room($newResident->residentName, $newResident->bookingFrom, $newResident->bookingTo);
            $dataBase = new DB();
            $dataBase->CreateRoom($this->rooms[$roomNumber-1], $roomNumber);
        }
        else
        {
            throw new Exception("The room $roomNumber is already booked by<br/>" . $this->GetInfoAboutBookerInRoom($roomNumber));
        }
    }

    public function GetInfoAboutBookerInRoom($roomNumber)
    {
        if(!$this->IsRoomEmpty($roomNumber))
        {
            $lookindRoom = $this->rooms[$roomNumber - 1];
            return "Booker name is " . $lookindRoom->residentName . "<br/>Room is booked from " .
            $lookindRoom->bookedFrom . "<br/>Room is booked to " . $lookindRoom->bookedTo . "<br/>";
        }
        else
        {
            return "Room is empty";
        }
    }

    public function Notify($resident, $roomNumber)
    {
        // это метод заглушка
        echo "<script type='text/javascript'>alert(\"notify by phone number $resident->phoneNubmer: You, $resident->residentName, have booked room $roomNumber\")</script>";
        echo "<script type='text/javascript'>alert(\"notify by email address $resident->eAddress: You, $resident->residentName, have booked room $roomNumber\")</script>";
    }
}
?>