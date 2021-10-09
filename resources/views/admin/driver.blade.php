@extends('admin.layout.default')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/jquery.dataTables.min.css') }}">
@endsection

@section('jsPostApp')
    <script src="{{ asset('plugins/datatable/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            
		    $('select[name=DataTables_Table_0_length]').show();
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
            $('#open_adddriver').click(function(){
                $('#div_adddriver').show();
            })
            $('.open_editdriver').click(function(){
                $('#edit_id').val($(this).next().val());
                $('#edit_driver_id').val($(this).next().next().val());
                $('#edit_name').val($(this).next().next().next().val());
                $('#div_editdriver').show();
            })
                
            $('.filestyle1').on('change',function(e){
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onloadend =function(){
                    $('#image1').show();
                    $('#image1')
                            .attr('width','300')
                            .attr('height','300')
                            .attr('src',reader.result);  
                }
                reader.readAsDataURL(file);    
            });
            $('.filestyle2').on('change',function(e){
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onloadend =function(){
                    $('#image2').show();
                    $('#image2')
                            .attr('width','300')
                            .attr('height','300')
                            .attr('src',reader.result);    
                }
                reader.readAsDataURL(file);    
            });
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row" id="div_adddriver" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Driver Info</h5>
                    <form  action="{{ url('/admin/adddriver') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="id" name="id" class="validate" required>
                                <label for="id" class="active">ID</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>File</span>
                                    <input class="filestyle margin images filestyle1" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" >
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div style="text-align:center">
                                    <img class="images" id="image1" src="#" alt="Your Logo" style="display:none"/>
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
                    <h5>Edit Driver Info</h5>
                    <form  action="{{ url('/admin/editdriver') }}" method="POST"   enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="edit_id" name="edit_id" class="validate" required>
                        <div class="row">
                            <div class="input-field col s6">
                                <input type="text" id="edit_driver_id" name="edit_driver_id" class="validate" required>
                                <label for="edit_driver_id" class="active">ID</label>
                            </div>
                            <div class="input-field col s6">
                                <input type="text" id="edit_name" name="edit_name" class="validate" required>
                                <label for="edit_name" class="active">Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6 file-field">
                                <div class="btn">
                                    <span>New File</span>
                                    <input class="filestyle margin images filestyle2" data-input="false" type="file" name="image" data-buttonText="Upload Logo" data-size="sm" data-badge="false">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" >
                                </div>
                            </div>
                            <div class="input-field col s6">
                                <div style="text-align:center">
                                    <img class="images" id="image2" src="#" alt="Your Logo" style="display:none"/>
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
                        <h5 class="content-headline">Driver Info Table</h5>
                    </div>

                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_adddriver"  data-position="bottom" data-delay="50" data-tooltip="Create new driver"><i class="material-icons">add</i></a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <td>{{$driver->driver_id }}</td>
                                            <td>{{$driver->name }}</td>
                                            <td><img style="width:100px;Height:100px;"src="{{ asset('upload/driver') }}/{{$driver->filename}}"></td>
                                            <td>{{Carbon\Carbon::parse($driver->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating wornging-bg open_editdriver" href="#"  id="">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <input type="hidden" value="{{$driver->id}}">
                                                    <input type="hidden" value="{{$driver->driver_id}}">
                                                    <input type="hidden" value="{{$driver->name}}">
                                                </div>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/deldriver/'.$driver->id)}}">
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
