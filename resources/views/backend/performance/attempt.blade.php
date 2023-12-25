@extends('backend.index')
@section('content')
    <div class="container-fluid">
        {{-- POP --}}

        <div class="popover bs-popover-auto fade" role="tooltip" id="popover799385" data-popper-placement="top"
            style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(124px, -297px);">
            <div class="popover-arrow" style="position: absolute; left: 0px; transform: translate(128px, 0px);"></div>
            <h3 class="popover-header">Popover in Right</h3>
            <div class="popover-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</div>
        </div>

        <!-- Add Order -->
        <div class="modal fade" id="addclassmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <h5 class="modal-title">In order to allow second attempt set status = "Done"</h5>
                        </div>
                        <a href="{{ route('performance.attempt.done', $model->id) }}" type="submit"
                            class="btn btn-primary">Update</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('performance.list') }}">Performance</a></li>
                <li class="breadcrumb-item"><a>{{ $model->title }}</a></li>
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
                        <div></div>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#addclassmodal">Status</button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Score</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attempts as $attempt)
                                        <tr>
                                            <td>{{ $attempt->rel_user->name }} <br>
                                                <span style="font-size: 13px;font-weight: 600;color: #817979;"> ID :
                                                    {{ $attempt->rel_user->student_id }}</span>
                                            </td>
                                            <td> <span class="badge badge-success">{{ $attempt->result['correct'] }} /
                                                    {{ $attempt->result['total'] }}</span>
                                                <br>
                                                <span class="badge badge-success">{{ $attempt->result['time_taken'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="badge badge-xs light badge-{{ $attempt->status != 0 ? 'success' : 'warning' }} mr-1">
                                                        {{ $attempt->status }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('tests.show', $attempt->id) }}"
                                                        class="btn btn-success shadow btn-xs sharp me-1"
                                                        value="{{ $attempt->id }}"><i class="fa fa-download"></i></a>
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
                var question_id = $(this).val();
                // alert(question_id);
                $('#editmodal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/question/" + question_id + "/edit",
                    success: function(response) {
                        console.log(response);
                        $('#question_test_text').val(response.question_test_text);
                        $('#question_test_image').val(response.question_test_image);
                        $('#test_id').val(response.test_id);
                        $('#id').val(response.id);
                    }
                });
            })
        })
    </script>
    <script>
        $(function() {
            $('[data-bs-toggle="popover"]').popover()
        })
    </script>
@endsection
