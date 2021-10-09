<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tourlist;
use App\busstop;
use App\tour;
use App\driver;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login($id)
    {
        $tour = tourlist::select()->where('booking_id',$id)->first();
        if(is_null($tour)){
            $return = array('status' => 'No');
        }
        else{
            $return = array('status' => 'Yes');
        }
        return json_encode($return); 
    }
    public function token($id,$token)
    {
        $tour = tourlist::select()->where('booking_id',$id)->first();
        if(is_null($tour)){
            $return = array('status' => 'No');
        }
        else{
            $tour->device_token = $token;
            $tour->save();
            $return = array('status' => 'Yes');
        }
        return json_encode($return); 
    }
    public function arrived($id)
    {
        $tour = tourlist::select()->where('booking_id',$id)->first();
        if(is_null($tour)){
            $return = array('status' => 'No');
        }
        else{
            $tour->clicked = 'yes';
            $tour->save();
            $return = array('status' => 'Yes');
        }
        return json_encode($return); 
    }
    public function getbusstops ()
    {
        $busstops = busstop::select('id','name','lat','long')
                    ->get();
        $return = array('status' => 'yes','busstops' => $busstops);
        return json_encode($return);  
    }
  /*  public function getbusstop ($id)
    {
        $tourlist = tourlist::select()->where('booking_id',$id)->first();
        $busstop = busstop::select()->where('id',$tourlist->busstop)->first();
        $return = array('status' => 'yes','busstop' => $busstop);
        return json_encode($return);  
    }*/
    public function getbusinfo($id)
    {
        $tourlist = tourlist::select()->where('booking_id',$id)->first();
        $tour = tour::select('id','name','filename','bus_nuber','time')->where('id',$tourlist->tour_id)->first();
        $return = array('status' => 'yes','tour' => $tour, 'arrive'=>$tourlist->clicked);
        return json_encode($return); 
    }
    public function givelocation (Request $request)
    {
    }
    public function dlogin($id)
    {
        $driver = driver::select()->where('driver_id',$id)->first();
        if(is_null($driver)){
            $return = array('status' => 'No');
        }
        else{
            $tour = tour::select('id','name')
                ->where('driver_id',$driver->driver_id)
                ->first();
            if(is_null($tour)){
                $return = array('status' => 'Yes','passengers' => null);
            }
            else{
                    $tourlist = tourlist::select('tourlists.id','tourlists.passenger_name','tourlists.clicked','tourlists.onbus','tours.name as tourname')
                                        ->leftjoin('tours','tourlists.tour_id','=','tours.id')
                                        ->where('tourlists.tour_id',$tour->id)
                                        ->where('tourlists.time',date('Y-m-d'))
                                        ->get();
                $return = array('status' => 'Yes','passengers' => $tourlist);
            }
        }
        return json_encode($return); 
    }
    public function donbus($id)
    {
        $tourlist = tourlist::select()->where('id',$id)->first();
        if(is_null($tour)){
            $return = array('status' => 'No');
        }
        else{
            $tourlist->onbus = 'yes';
            $tourlist->save();
            $return = array('status' => 'Yes');
        }
        return json_encode($return); 
    }
    public function dlocation($id,$lat,$long)
    {
        $driver = driver::select()->where('driver_id',$id)->first();
        if(is_null($driver)){
            $return = array('status' => 'No');
        }
        else{
            $driver->lat = $lat;
            $driver->long = $long;
            $driver->save();
            $return = array('status' => 'Yes');
        }
        return json_encode($return); 
    }
}
