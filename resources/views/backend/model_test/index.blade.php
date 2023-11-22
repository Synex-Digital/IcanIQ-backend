@extends('backend.index')
@section('content')
<div class="container-fluid">
    <!-- Add Order -->
    <div class="modal fade" id="addclassmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Model Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('modeltest.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Select Class</label>
                            <select class="default-select  form-control wide" name="class_id">
                                @foreach ($classes as $class)
                                 <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" placeholder="Model Test Title">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Duration</label>
                            <input class="form-control clockpicker" type="text" id="timepicker">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Write Note</label>
                            <textarea class="form-control" name="note" id="" cols="10" rows="5" placeholder="Write Note For This Model Test"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <select class="default-select  form-control wide" name="status">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- edit modal  --}}
    <div class="modal fade" id="editmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('class.update', 'id') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group mb-3">
                            <label class="form-label">Class Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Class Name">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <select class="default-select  form-control wide" name="status">
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Datatable</a></li>
        </ol>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile Datatable</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addclassmodal">+Model Test</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 850px">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->class_name }}</td>
                                    <td>{{ $request->status == '1' ? 'Active' : 'Deactive' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-primary shadow btn-xs sharp me-1 editbtn" value="{{ $request->id }}"><i class="fa fa-pencil"></i></button>
                                            <form action="{{ route('class.destroy', $request->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>												
                                    </td>												
                                </tr>
                                @endforeach --}}
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- @section('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.editbtn', function(){
                var class_id = $(this).val();
               $('#editmodal').modal('show');

               $.ajax({
                type: "GET",
                url: "/class/"+class_id+"/edit",
                success: function(response){
                    // console.log(response);
                    $('#name').val(response.class_name);
                    $('#id').val(response.id);
                }
               });
            })
        })
    </script>
@endsection --}}