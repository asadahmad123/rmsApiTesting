<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabin;


class CabinController extends Controller
{
    public function index(){
        $data = Cabin::all();
        // compact('data')
        // $cabin = new Cabin;
        // $cabin->name = 'Room';
        // $cabin->cabin_id = 25;
        // $cabin->site_id = 10;
        // $cabin->save();
//         echo "<pre>";
// print_r($data); 
// echo "</pre>";
// die;
        return(dd($data));
    }
}
