@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <!-- Add Order -->
        <div class="modal fade" id="addclassmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="form-group mb-3">
                                <label class="form-label">Select Class</label>
                                <select class="default-select  form-control wide" name="class_id">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group mb-3">
                                <label class="form-label">Student's Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Elon Mask" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Student's Email</label>
                                <input type="text" class="form-control" name="email" placeholder="example@gmail.com"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Student's Number</label>
                                <input type="text" class="form-control" name="number" placeholder="+880" value="+880"
                                    required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" id="dz-password" class="form-control" value=""
                                        name="password" placeholder="Entire Password" required>
                                    <span class="show-pass eye">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Profile</label>
                                <input type="file" class="form-control" name="profile">
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
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('student.update', 'id') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id" value="">

                            <div class="form-group mb-3">
                                <label class="form-label">Student's Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Student's Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Student's Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Student's Number</label>
                                <input type="text" class="form-control" name="number" id="number"
                                    placeholder="Student's Number" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" id="dz-password" class="form-control" value=""
                                        name="password" placeholder="Entire Password">
                                    <span class="show-pass eye">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Profile</label>
                                <input type="file" id="" class="form-control" value=""
                                    name="profile">
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
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Students List</h4>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#addclassmodal">+Add Student</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>
                                                <img style="width: 50px;"
                                                    src="{{ asset('files/student/' . $request->profile) }}">
                                            </td>
                                            <td>{{ $request->name }}</td>
                                            <td>{{ $request->email }}</td>
                                            <td>{{ $request->number }}</td>
                                            <td>{{ $request->status == '1' ? 'Active' : 'Deactive' }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-primary shadow btn-xs sharp me-1 editbtn"
                                                        value="{{ $request->id }}"><i class="fa fa-pencil"></i></button>

                                                    <button type="button"
                                                        class="btn btn-danger shadow btn-xs sharp delete"
                                                        data-bs-toggle="modal" data-bs-target="#basicModal"
                                                        data-user-id="{{ route('student.destroy', $request->id) }}"><i
                                                            class="fa fa-trash"></i></button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="basicModal">
                                                        <div class="modal-dialog" role="document">
                                                            <form id="deleteID" action="" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Delete model</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal">
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">Are you sure you want to delete
                                                                        this model? This action cannot be undone.
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-danger light"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.editbtn', function() {
                var class_id = $(this).val();
                $('#editmodal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/student/" + class_id + "/edit",
                    success: function(response) {
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#number').val(response.number);
                        $('#profile').val(response.profile);
                        $('#id').val(response.id);
                    }
                });
            })
            $('.delete').on('click', function(e) {
                e.preventDefault(); // Prevent the default action

                var userId = $(this).data('user-id');
                $('#deleteID').attr('action', userId);
            });
        })
    </script>
@endsection
