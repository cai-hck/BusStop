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
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
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
    public function editdriver(Request $request)
    {
        $driver = driver::select()
            ->where('id',$request->edit_id)
            ->first();
        $driver->driver_id = $request->edit_driver_id;
        $driver->name = $request->edit_name;
        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
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
        $tour->bus_number = $request->bus_number;
        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
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
    }
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
    }
    public function today()
    {
        $tours = tour::select()
                    ->get();
        $tourlists = tourlist::select('tourlists.id','tourlists.time','tours.name','tourlists.passenger_name','tourlists.passenger_phone','tourlists.busstop')
                    ->leftjoin('tours','tourlists.tour_id','=','tours.id')
                    ->get();
        return view('admin.today')
                ->with('tourlists',$tourlists)
                ->with('tours',$tours);
    }
    public function addpt(Request $request)
    {
        $tourlist = new tourlist();
        $tourlist->time = $request->time;
        $tourlist->tour_id = $request->tour_id;
        $tourlist->passenger_name = $request->passenger_name;
        $tourlist->passenger_phone = $request->passenger_phone;
        $tourlist->busstop = $request->busstop;
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
}
