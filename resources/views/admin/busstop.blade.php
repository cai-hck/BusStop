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
            $('#open_addbusstop').click(function(){
                $('#div_addbusstop').show();
            })
        } );
    </script>
@endsection

@section('content')
<div class="main-container">
    <div class="row" id="div_addbusstop" style="display:none">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <h5>Add Busstop Info</h5>
                    <form  action="{{ url('/admin/addbusstop') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="name" name="name" class="validate" required>
                                <label for="name" class="active">Name</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="lat" name="lat" class="validate" required>
                                <label for="lat" class="active">Lat</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="long" name="long" class="validate" required>
                                <label for="long" class="active">Long</label>
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
                        <h5 class="content-headline">Busstop Info Table</h5>
                    </div>

                    <a class="btn-floating btn-large waves-effect waves-light red tooltipped" id="open_addbusstop"  data-position="bottom" data-delay="50" data-tooltip="Create new Busstop"><i class="material-icons">add</i></a>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper" style="    overflow: auto;   position: relative;width: 100%;">
                            <table class="datatable-badges display cell-border" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Lat</th>
                                    <th>Long</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($busstops as $busstop)
                                        <tr>
                                            <td>{{$busstop->name }}</td>
                                            <td>{{$busstop->lat }}</td>
                                            <td>{{$busstop->long }}</td>
                                            <td>{{Carbon\Carbon::parse($busstop->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delbusstop/'.$busstop->id)}}">
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
