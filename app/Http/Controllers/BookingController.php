<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RmsService;


class BookingController extends Controller

{
    const data = [array
        (
            "adults"=> 4,
            "children"=> 0,
            "companyId"=> 0,
            "infants"=> 2,
            "resTypeId"=> 0,
            "id"=> 16311,
            "accountId"=> 297344,
            "areaId"=> 3,
            "arrivalDate"=> "2023-11-17 14:00:00",
            "cancelledDate"=> "2021-09-15 14:37:45",
            "categoryId"=> 1,
            "departureDate"=> "2023-11-30 11:00:00",
            "guestId"=> 007,
            "rateTypeId"=> 1,
            "status"=> "Cancelled"
        ),
        array
        (
            "adults"=> 3,
            "children"=> 0,
            "companyId"=> 0,
            "infants"=> 0,
            "resTypeId"=> 0,
            "id"=> 16300,
            "accountId"=> 297344,
            "areaId"=> 3,
            "arrivalDate"=> "2023-11-17 14:00:00",
            "cancelledDate"=> "2021-09-15 14:37:45",
            "categoryId"=> 1,
            "departureDate"=> "2023-11-25 11:00:00",
            "guestId"=> 117,
            "rateTypeId"=> 1,
            "status"=> "Cancelled"
        )
    ];

       
        
    public function index(){
        $data = new RmsService(1,'2023-01-01 00:00:00', "Room");
        $result = $data->getReservationData();
        // $result = Self::data;
        // return $result;
        if(!empty($result)){
            $data->preprocessData($result);

        }
 
    }
    
}