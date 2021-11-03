<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Admin;
use App\driver;
use App\passenger;
use App\tour;
use App\tourlist;
use App\Permission;
use App\busstop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = collect();
        $data->usersCount      = User::count();
        $data->adminCount      = Admin::count();
        $data->tourCount       = tour::count();
        $data->passengerCount = passenger::count();
        $data->driver = driver::count();

        $data->roles = Role::all();
        $data->permissions = Permission::all();
        $drivers = driver::select()
                            ->get();
        return view('admin.home', compact('data'))
                ->with('drivers',$drivers);
    }
    public function driver()
    {
        $drivers = driver::select()
                            ->get();
        return view('admin.driver')
                ->with('drivers',$drivers);
    }
    public function adddriver(Request $request)
    {
        $driver = new driver();
        $driver->driver_id = $request->id;
        $driver->name = $request->name;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/driver');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $driver->filename = $name;
        }
        $driver->save();
        return back();
    }
    public function deldriver($id)
    {
        $driver = driver::select()
                    ->where('id',$id)
                    ->first();
        $driver->delete();
        return back();
    }
    public function busstop()
    {
        $busstops = busstop::select()
                            ->get();
        return view('admin.busstop')
                ->with('busstops',$busstops);
    }
    public function addbusstop(Request $request)
    {
        $busstop = new busstop();
        $busstop->name = $request->name;
        $busstop->lat = $request->lat;
        $busstop->long = $request->long;
        $busstop->save();
        return back();
    }
    public function delbusstop($id)
    {
        $busstop = busstop::select()
                    ->where('id',$id)
                    ->first();
        $busstop->delete();
        return back();
    }
    public function editdriver(Request $request)
    {
        $driver = driver::select()
            ->where('id',$request->edit_id)
            ->first();
        $driver->driver_id = $request->edit_driver_id;
        $driver->name = $request->edit_name;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/driver');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $driver->filename = $name;
        }
        $driver->save();
        return back();
    }
    public function tour()
    {
        $tours = tour::select()
                            ->get();
        $drivers = driver::select()
        ->get();
        return view('admin.tour')
             ->with('drivers',$drivers)
                ->with('tours',$tours);
    }
    public function addtour(Request $request)
    {
        $tour = new tour();
        $tour->name = $request->name;
        $tour->driver_id = $request->driver_id;
        $tour->time = $request->time;
        $tour->bus_number = $request->bus_number;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/tour');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $tour->filename = $name;
        }
        $tour->save();
        return back();
    }
    public function edittour(Request $request)
    {
        $tour = tour::select()
            ->where('id',$request->edit_id)
            ->first();
        $tour->name = $request->edit_name;
        $tour->driver_id = $request->edit_driver_id;
        $tour->time = $request->edit_time;
        $tour->bus_number = $request->edit_bus_number;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand(11111, 99999).$_FILES["image"]["name"];
            $destinationPath = public_path('/upload/tour');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $tour->filename = $name;
        }
        $tour->save();
        return back();
    }
    public function deltour($id)
    {
        $tour = tour::select()
                    ->where('id',$id)
                    ->first();
        $tour->delete();
        return back();
    }/*
    public function passenger()
    {
        $passengers = passenger::select()
                    ->get();
        $drivers = driver::select()
                    ->get();
        return view('admin.passenger')
                ->with('passengers',$passengers);
    }
    public function addpassenger(Request $request)
    {
        $passenger = new passenger();
        $passenger->name = $request->name;
        $passenger->Phone = $request->Phone;
        $passenger->busstop = $request->busstop;
        $passenger->save();
        return back();
    }
    public function delpassenger($id)
    {
        $passenger = passenger::select()
                    ->where('id',$id)
                    ->first();
        $passenger->delete();
        return back();
    }*/
    public function today()
    {
        $tours = tour::select()
                    ->get();
        $busstops = busstop::select()
                    ->get();
        $otourlists = tourlist::select('tourlists.id','tourlists.time','tours.name','tourlists.booking_id','tourlists.passenger_name','tourlists.passenger_phone','tourlists.busstop')
                    ->leftjoin('tours','tourlists.tour_id','=','tours.id')
                    ->where('tourlists.time','<',date('Y-m-d'))
                    ->get();
        $tourlists = tourlist::select('tourlists.id','tourlists.time','tours.name','tourlists.booking_id','tourlists.passenger_name','tourlists.passenger_phone','tourlists.busstop')
                    ->leftjoin('tours','tourlists.tour_id','=','tours.id')
                    ->where('tourlists.time',date('Y-m-d'))
                    ->get();
        $ftourlists = tourlist::select('tourlists.id','tourlists.time','tours.name','tourlists.booking_id','tourlists.passenger_name','tourlists.passenger_phone','tourlists.busstop')
                    ->leftjoin('tours','tourlists.tour_id','=','tours.id')
                    ->where('tourlists.time','>',date('Y-m-d'))
                    ->get();
        return view('admin.today')
                ->with('tourlists',$tourlists)
                ->with('otourlists',$otourlists)
                ->with('ftourlists',$ftourlists)
                ->with('busstops',$busstops)
                ->with('tours',$tours);
    }
    public function push()
    {
        $tourlists = tourlist::select()
                    ->get();

        foreach($tourlists as $tourlist){
            if($tourlist->device_token != '' && $tourlist->time == date('Y-m-d')  && $tourlist->clicked == '' ){
                $ch = curl_init();
                $headers  = [
                            'Content-Type: application/json',
                        ];
                $postData = [
                    'to' => $tourlist->device_token,
                    'title' => 'Hello '.$tourlist->passenger_name,
                    'body' => 'Please arrive to busstop!!! You can check Bus info in your App',
                ];
                curl_setopt($ch, CURLOPT_URL,'https://exp.host/--/api/v2/push/send');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            }
        }
        return back();
    }
    public function addpt(Request $request)
    {
        $tourlist = new tourlist();
        $tourlist->time = $request->time;
        $tourlist->tour_id = $request->tour_id;
        $tourlist->passenger_name = $request->passenger_name;
        $tourlist->passenger_phone = $request->passenger_phone;
   //     $tourlist->busstop = $request->busstop;
        $tourlist->booking_id = $request->booking_id;
        $tourlist->save();
        return back();
    }
    public function delpt($id)
    {
        $tourlist = tourlist::select()
                    ->where('id',$id)
                    ->first();
        $tourlist->delete();
        return back();
    }
    
    public function getdriver()
    {
        $drivers = driver::select('name','lat','long')->get();
        return json_encode($drivers);
    }
}
