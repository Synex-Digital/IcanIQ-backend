@extends('backend.index')
@section('content')
    <div class="container-fluid">
        {{-- POP --}}

        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('modeltest.index') }}">Performance</a></li>
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
                    {{-- <div class="card-header">
                        {{-- <h4 class="card-title">{{ $modeltests->title }}</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#addclassmodal">+Add Question</button>
                </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>Model</th>
                                        <th>Participants</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($models as $model)
                                        <tr>
                                            <td>{{ $model->title }}</td>
                                            <td><span class="badge badge-primary">{{ $model->count }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="badge badge-xs light badge-{{ $model->status != 0 ? 'success' : 'warning' }} mr-1">
                                                        Result
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('performance.list.attempt', $model->id) }}"
                                                        class="btn btn-success shadow btn-xs sharp me-1"
                                                        value="{{ $model->id }}"><i class="fa fa-eye"></i></a>
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
