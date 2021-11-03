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
                }, {
                    width: '15%',
                    targets: [4]
                }, {
                    width: '15%',
                    targets: [5]
                },{
                    width: 'auto',
                    targets: [6]
                }]
            });
		    $('select[name=DataTables_Table_0_length]').show();
            $('#open_addtour').click(function(){
                $('#div_addtour').show();
            })
            $('.open_edittour').click(function(){
                $('#edit_id').val($(this).next().val());
                $('#edit_name').val($(this).next().next().val());
                $('#edit_bus_number').val($(this).next().next().next().val());
                $('#edit_time').val($(this).next().next().next().next().val());
                $('#edit_driver_id').val($(this).next().next().next().next().next().val());
                $('#edit_file').val($(this).next().next().next().next().next().next().val());
                $('#div_editdriver').show();
            })
        } );
        $('.filestyle').on('change',function(e){
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.onloadend =function(){
            $('.image').show();
            $('.image')
                    .attr('width','300')
                    .attr('height','300')
                    .attr('src',reader.result);    
        }
        reader.readAsDataURL(file);    
        });
    </script>
@endsection

@section('content')
<div class="main-container">
    
    <div class="row" id="div_addtour" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Tour</h5>
                    <form  action="{{ url('/admin/addtour') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="bus_number" name="bus_number" class="validate" required>
                                <label for="bus_number" class="active">Bus Number</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="time" id="time" name="time" class="validate" required>
                                <label for="time" class="active">Time</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <select id="single-select1" class="basic-select" name="driver_id" required>
                                    <option value="" disabled="disabled" selected="selected">Choose your option</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{$driver->driver_id}}">{{$driver->driver_id}}</option>
                                    @endForeach
                                </select>
                                <label for="single-select1">Driver ID</label>
                            </div>
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input class="filestyle margin images" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <div style="text-align:center">
                                    <img class="images" id="image" src="#" alt="Your Logo" style="display:none"/>
                                </div>
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
    <div class="row" id="div_editdriver" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Edit Tour</h5>
                    <form  action="{{ url('/admin/edittour') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="edit_id" class="validate" required>
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="edit_name" name="edit_name" class="validate" required>
                                <label for="edit_name" class="active">Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="edit_bus_number" name="edit_bus_number" class="validate" required>
                                <label for="edit_bus_number" class="active">Bus Number</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="time" id="edit_time" name="edit_time" class="validate" required>
                                <label for="edit_time" class="active">Time</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <select id="edit_driver_id" class="basic-select" name="edit_driver_id" required >
                                    <option value=""></option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{$driver->driver_id}}">{{$driver->driver_id}}</option>
                                    @endForeach
                                </select>
                                <label for="edit_driver_id">Driver ID</label>
                            </div>
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input class="filestyle margin images" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" id="edit_file">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <div style="text-align:center">
                                    <img class="images" id="image" src="#" alt="Your Logo" style="display:none"/>
                                </div>
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
                        <h5 class="content-headline">Tour Table</h5>
                    </div>
                    <!-- Modal Structure -->
                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_addtour"  data-position="bottom" data-delay="50" data-tooltip="Create new tour"><i class="material-icons">add</i></a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border datatable-badges2" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Time</th>
                                    <th>Driver Id</th>
                                    <th>Bus Number</th>
                                    <th>Photo</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tours as $tour)
                                        <tr>
                                            <td>{{$tour->name }}</td>
                                            <td>{{$tour->time }}</td>
                                            <td>{{$tour->driver_id }}</td>
                                            <td>{{$tour->bus_number }}</td>
                                            <td><img style="width:100px;Height:100px;"src="https://yhdevfull.com/bus/bus/public/upload/tour/{{$tour->filename}}"></td>
                                            <td>{{Carbon\Carbon::parse($tour->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating wornging-bg open_edittour" href="#"  id="">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <input type="hidden" value="{{$tour->id}}">
                                                    <input type="hidden" value="{{$tour->name}}">
                                                    <input type="hidden" value="{{$tour->bus_number}}">
                                                    <input type="hidden" value="{{$tour->time}}">
                                                    <input type="hidden" value="{{$tour->driver_id}}">
                                                    <input type="hidden" value="{{$tour->filename}}">
                                                </div>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/deltour/'.$tour->id)}}">
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
