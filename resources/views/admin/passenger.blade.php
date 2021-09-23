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
                    width: '20%',
                    targets: [0]
                }, {
                    width: '20%',
                    targets: [1]
                }, {
                    width: '20%',
                    targets: [2]
                }, {
                    width: '20%',
                    targets: [3]
                },{
                    width: 'auto',
                    targets: [4]
                }]
            });
		    $('select[name=DataTables_Table_0_length]').show();
            $('#open_addpassenger').click(function(){
                $('#div_addpassenger').show();
            })
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    
    <div class="row" id="div_addpassenger" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Passenger Info</h5>
                    <form  action="{{ url('/admin/addpassenger') }}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="Phone" name="Phone" class="validate" required>
                                <label for="Phone" class="active">Phone</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <select id="single-select1" class="basic-select" name="busstop" required>
                                    <option value="" disabled="disabled" selected="selected">Choose your option</option>
                                    @for( $i = 3; $i < 9 ; $i ++)
                                        <option value="{{$i}}">{{$i}} BusStop</option>
                                    @endFor
                                </select>
                                <label for="single-select1">Bus Stop</label>
                            </div>
                            <div class="input-field col s6">
                                <select id="single-select1" class="basic-select" name="busstop" required>
                                    <option value="" disabled="disabled" selected="selected">Choose your option</option>
                                    @for( $i = 3; $i < 9 ; $i ++)
                                        <option value="{{$i}}">{{$i}} BusStop</option>
                                    @endFor
                                </select>
                                <label for="single-select1">Bus Stop</label>
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
                        <h5 class="content-headline">Passengers Table</h5>
                    </div> 
                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_addpassenger"  data-position="bottom" data-delay="50" data-tooltip="Create new passenger"><i class="material-icons">add</i></a>
                    
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Bus Stop</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($passengers as $passenger)
                                        <tr>
                                            <td>{{$passenger->name }}</td>
                                            <td>{{$passenger->phone }}</td>
                                            <td>{{$passenger->busstop }}</td>
                                            <td>{{Carbon\Carbon::parse($passenger->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delpassenger/'.$passenger->id)}}">
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
