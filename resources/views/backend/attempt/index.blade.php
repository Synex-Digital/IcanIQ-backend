@extends('backend.index')
@section('content')
    <div class="container-fluid">
        {{-- edit --}}
        <div class="modal fade" id="editmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Attemp</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('requests.update', 'id') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id">

                            <div class="form-group mb-3">
                                <label class="form-label">Status</label>
                                <select class="default-select  form-control wide" name="status">
                                    <option value="accept">Accept</option>
                                    <option value="reject">Reject</option>
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
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if ($attempt->first() && $attempt->first()->id != null)
                    <li class="breadcrumb-item active"><a href="#">{{ $attempt->first()->model->title }}</a>
                    </li>
                @endif
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
                        <div>
                            <form class="form" id="formFilter" action="" method="get">
                                @csrf
                                <div class="row g-3">
                                    <div class="col mr-2">
                                        <select name="status" class="form-control" id="selectedOption">
                                            <option value="clear">Clear</option>
                                            <option value="accept" selected>Accept</option>
                                            <option value="done">Done</option>
                                            <option value="result">Processing</option>
                                            <option value="reject">Reject</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col ">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if ($attempt->first() && $attempt->first()->id != null)
                            <form action="{{ route('attempt.all') }}" method="POST">
                                @csrf
                                <input type="hidden" name="model_id" value="{{ $attempt->first()->model_id }}">
                                <button type="submit" name="btn" value="1" class="btn btn-secondary"
                                    data-bs-toggle="modal" data-bs-target="#addclassmodal">+Accept</button>
                                <button type="submit" name="btn" value="2" class="btn btn-secondary"
                                    data-bs-toggle="modal" data-bs-target="#addclassmodal">+Reject</button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attempt as $attemp)
                                        <tr>
                                            <td>{{ $attemp->rel_user->name }}</td>
                                            <td>
                                                {{ $attemp->status }}
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-primary shadow btn-xs sharp me-1 editbtn"
                                                        value="{{ $attemp->id }}"><i class="fa fa-pencil"></i></button>

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
                    url: "/requests/" + class_id + "/edit",
                    success: function(response) {
                        console.log(response);
                        $('#status').val(response.status);
                        $('#id').val(response.id);
                    }
                });
            })

            $('#selectedOption').change(function() {
                console.log('hi');
                $('#submitForm').submit(); // Submit the form when select value changes
            }).trigger('change');
        })
    </script>
@endsection
