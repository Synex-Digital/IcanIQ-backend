@extends('backend.index')
@section('content')
    <div class="container-fluid">

        {{-- edit modal  --}}
        <div class="modal fade" id="editmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Requests</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('requests.update', 'id') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id">
                            <div class="form-group mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Model Test Title">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Exam Time</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-control" name="hours" id="hours">
                                            <option value="0" selected>0 hour</option>
                                            <option value="1">1 hour</option>
                                            <option value="2">2 hours</option>
                                            <!-- Add more hour options as needed -->
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-control" name="minutes" id="minutes">
                                            <option value="0">0 minutes</option>
                                            <option value="15">15 minutes</option>
                                            <option value="30">30 minutes</option>
                                            <option value="45" selected>45 minutes</option>
                                            <!-- Add more minute options as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Write Note</label>
                                <textarea class="form-control" name="note" id="note" cols="10" rows="5"
                                    placeholder="Write Note For This Model Test"></textarea>
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
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Model</a></li>
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
                        <h4 class="card-title">Requests</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Request</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $request->title }}</td>
                                            <td>
                                                <span class="badge badge-sm light badge-primary">
                                                    {{ $request->attemptRequest->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('requests.show', $request->id) }}"
                                                        class="btn btn-success shadow btn-xs sharp me-1"
                                                        value="{{ $request->id }}"><i class="fa fa-eye"></i></a>

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
                    url: "/modeltest/" + class_id + "/edit",
                    success: function(response) {
                        console.log(response);
                        $('#title').val(response.title);
                        $('#start_time').val(response.start_time);
                        $('#end_time').val(response.end_time);
                        $('#note').val(response.note);
                        $('#id').val(response.id);
                    }
                });
            })
        })
    </script>
@endsection
