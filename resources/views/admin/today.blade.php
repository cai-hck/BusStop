@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('plugins/select2/select2.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
		    $('select').material_select();
            $('.datatable-badges').DataTable({
                columnDefs: [{
                    width: '15%',
                    targets: [0]
                }, {
                    width: '15%',
                    targets: [1]
                }, {
                    width: '15%',
                    targets: [2]
                }, {
                    width: '15%',
                    targets: [3]
                },{
                    width: '15%',
                    targets: [4]
                },{
                    width: '10%',
                    targets: [5]
                },{
                    width: 'auto',
                    targets: [6]
                }]
            });
		    $('select[name=DataTables_Table_0_length]').show();
            $('#open_addtourlist').click(function(){
                $('#div_addtourlist').show();
            })
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    
    <div class="row" id="div_addtourlist" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Tour</h5>
                    <form  action="{{ url('/admin/addpt') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="date" id="time" name="time" class="validate" required>
                                <label for="time" class="active">Tour Date</label>
                            </div>
                            <div class="input-field col s6">
                                <select id="single-select1" class="basic-select" name="tour_id" required>
                                    <option value="" disabled="disabled" selected="selected">Choose your option</option>
                                    @foreach ($tours as $tour)
                                        <option value="{{$tour->id}}">{{$tour->name}}</option>
                                    @endForeach
                                </select>
                                <label for="single-select1">Tour Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="passenger_name" name="passenger_name" class="validate" required>
                                <label for="passenger_name" class="active">Passenger Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="passenger_phone" name="passenger_phone" class="validate" required>
                                <label for="passenger_phone" class="active">Passenger Phone</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <select id="single-select2" class="basic-select" name="busstop" required>
                                    <option value="" disabled="disabled" selected="selected">Choose your option</option>
                                    @foreach ($busstops as $busstop)
                                        <option value="{{$busstop->id}}">{{$busstop->name}}</option>
                                    @endForeach
                                </select>
                                <label for="single-select2">BusStop</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="booking_id" name="booking_id" class="validate" required>
                                <label for="booking_id" class="active">Booking ID</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 right-align">
                            <button class="btn waves-effect waves-set" type="submit" name="update_profile">Save<i class="material-icons right">save</i>
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- With Action-->
        <div class="col s12">
            <div class="card-panel">
                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">Tourlist Table</h5>
                    </div>
                    <!-- Modal Structure -->
                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_addtourlist"  data-position="bottom" data-delay="50" data-tooltip="Create new Passenger to Tour"><i class="material-icons">add</i></a>
                    <a class="waves-effect waves-light btn-large"  onclick="return confirm('Are you sure?')" href="{{ url('/admin/push/')}}">Send Push Notification</a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Booking ID</th>
                                    <th>Tour Name</th>
                                    <th>Passenger Name</th>
                                    <th>Passenger Phone</th>
                                    <th>Busstop</th>
                                    <th>Click</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tourlists as $tourlist)
                                        <tr>
                                            <td>{{$tourlist->time }}</td>
                                            <td>{{$tourlist->booking_id }}</td>
                                            <td>{{$tourlist->name }}</td>
                                            <td>{{$tourlist->passenger_name }}</td>
                                            <td>{{$tourlist->passenger_phone }}</td>
                                            <td>{{$tourlist->clicked }}</td>
                                            <td>{{$tourlist->busstop }}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delpt/'.$tourlist->id)}}">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
