<?php


namespace App\Services;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\CabinBooking;
use Illuminate\Support\Carbon;
use App\Models\Cabin;
use App\Helpers\BookingHelper;



class RmsService
{
    const BASE_URL = "https://restapi8.rmscloud.com/";
    const RESERVATION_SEARCH = "reservations/search";
    const ROOM_SEARCH = "areas/";

    const GET_TOKEN = "authToken";
    const LIMIT = 50;
    const BOOKED ="Booked";
    const CANCEL ="Cancelled";
    
    protected $propertyId;
    protected $date;
    public $cabinBooking;
    public $room_identifier;
    public $room_data;
    public $booking_helper;

    
    public function __construct($propertyId, $date, $identifier,)
    {
        $this->propertyId = $propertyId;
        $this->date = $date;
        $this->room_identifier = $identifier;
        $this->booking_helper = new BookingHelper();
    }
    
    private function getToken()
    {
        if (Cache::has('token')) {
            return Cache::get('token');
        } else {
            // Send request to authenticate
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(self::BASE_URL . self::GET_TOKEN, [
                'agentId' => 15,
                'agentPassword' => '1h&29$vk449f8',
                'clientId' => 11281,
                'clientPassword' => '6k!Dp$N4',
                'useTrainingDatabase' => false,
                'moduleType' => [
                    'pointOfSale',
                    'kiosk',
                ],
            ]);

            // Check if request was successful
            if ($response->successful()) {
                Cache::put('token', $response->json()['token'], now()->addMinutes(30));
                return $response->json()['token'];
            } else {
                return false;
            }
        }
    }
    
    public function getReservationData()
    {
        $token = $this->getToken();
        
        if ($token) {
            // Send request to search for reservations
            try{
                $query = self::BASE_URL . self::RESERVATION_SEARCH . "?limit=" . self::LIMIT . "&modelType=fullc&offset=0";
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'authtoken' => $token,
                ])->post($query, [
                    "propertyIds" => [
                        $this->propertyId,
                    ],
                    "arriveFrom" => $this->date,
                ]);
    
                return $response->json();
            }catch(\Exception $e){
                print_r($e);
            }
            
        }
    }

    // function to get the perticular room details
    public function getRoomDetails($area_id){
        $token = $this->getToken();
        
        if ($token) {
            // Send request to search for reservations
            try{
                $query = self::BASE_URL . self::ROOM_SEARCH . $area_id . "?modelType=basic";
                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'authtoken' => $token,
                ])->get($query);
                return $response->json();
            }catch(\Exception $e){
                print_r($e);
            }
            
        }
            
    }

    public function saveBooking($bookingData)

    {
        $this->room_data = $this->getRoomDetails($bookingData['areaId']);
        

        
    $check_cabin = $this->booking_helper->ifCabinExists($this->room_identifier. ' '.$this->room_data['name']);
    print_r($check_cabin);
    if($check_cabin[0]){

        $cabin_booking = new CabinBooking;
        $cabin_booking->site_id = 1;                //property
        $cabin_booking->external_booking_id = $bookingData['id'];
        $cabin_booking->cabin_id = $bookingData['areaId'];
        $cabin_booking->guest_id = $bookingData['guestId'];
        $cabin_booking->adults = $bookingData['adults'];
        $cabin_booking->children = $bookingData['children'];
        $cabin_booking->infent = $bookingData['infants'];
        $cabin_booking->checkin = $bookingData['arrivalDate'];
        $cabin_booking->checkout = $bookingData['departureDate'];
        // $cabin_booking->guest_f_name = $this->room_data['name'];
        // $cabin_booking->guest_f_name = $bookingData[''];


        
        // $cabin_booking->save();

    }

    }

    public function preProcessData($data)
    {
        foreach($data as $item)
        {
            $this->cabinBooking = CabinBooking::where('external_booking_id', $item['id'])->where('site_id',$this->propertyId)->first();
            if(empty($this->cabinBooking) ){
                $this->saveBooking($item);
            }

            if(!empty($this->cabinBooking)){
                $this->updateBooking($item);
            }

        }
    }

    public function updateBooking($bookingData)
    {
        if($bookingData['status']== self::CANCEL){
            $this->deleteBooking();
        }
        else{
            // $check_cabin = $this->booking_helper->ifCabinExists($this->room_identifier. ' '.$bookingData['room']);

            $this->cabinBooking->site_id = 1;                //property
            $this->cabinBooking->external_booking_id = $bookingData['id'];
            $this->cabinBooking->cabin_id = $bookingData['areaId'];
            $this->cabinBooking->guest_id = $bookingData['guestId'];
            $this->cabinBooking->adults = $bookingData['adults'];
            $this->cabinBooking->children = $bookingData['children'];
            $this->cabinBooking->infent = $bookingData['infants'];
            $this->cabinBooking->checkin = $bookingData['arrivalDate'];
            $this->cabinBooking->checkout = $bookingData['departureDate'];
            $this->cabinBooking->save();

        }
    }

    public function deleteBooking()
    {
        $this->cabinBooking->delete();
    }
}
