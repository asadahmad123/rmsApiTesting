<?php
namespace App\Helpers;
use App\Models\Cabin;

class AddCabin
{

    public function addRoom($room_identifier, $room_id)
    {
        $room_name = $room_identifier. ' '.$room_id;
        $cabin = new Cabin;
        $cabin->name = $room_name;
        $cabin->cabin_id = $this->room_id['id'];
        $cabin->site_id = 1;
        $cabin->save();
    }
}