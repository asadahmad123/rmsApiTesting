<?php

namespace App\Helpers;
use App\Models\Cabin;


class BookingHelper
{

    public function ifCabinExists($name)

    {
        $cabin = Cabin::where('name', $name)->get();
        if($cabin->count() <= 0 ) return array(false, 0, 0);
        return array(true, $cabin[0]->id );


    }
}
