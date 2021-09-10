<?php
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

class Office
{
    private const maxRooms = 5;
    private $rooms = [null];
    private static $_instance = null;

    public $TEMP;

    private function __construct()
    {
        $this->rooms[0] = new Room("Tom", time(), time());
    }

    public static function getInstance()
    {
        if(null === self::$_instance)
        {
            print_r(self::$_instance);
            echo self::$_instance;
            echo "creating new office";
            self::$_instance = new self();
        }

        print_r(self::$_instance);
        return self::$_instance;
    }
    
    public function IsRoomEmpty($roomNumber = 1)
    {
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
        if($roomNumber === Office::maxRooms || $roomNumber >= Office::maxRooms)
        {
            throw new Exception("There is only 5 rooms in Office. Index of Last room is 4.");
        }
        elseif($this->IsRoomEmptyInTime($roomNumber, $newResident->bookingFrom))
        {
            $this->rooms[$roomNumber]= new Room($newResident->residentName, $newResident->bookingFrom, $newResident->bookingTo);
        }
        else
        {
            throw new Exception("The room $roomNumber is already booked by" . $this->GetInfoAboutBookerInRoom($roomNumber));
        }
    }

    public function GetInfoAboutBookerInRoom($roomNumber)
    {
        $lookindRoom = $this->rooms[$roomNumber - 1];
        return "Booker name is " . $lookindRoom->residentName . "<br/>Room is booked from " .
        $lookindRoom->bookedFrom . "<br/>Room is booked to " . $lookindRoom->bookedTo . "<br/>";
    }

}
?>