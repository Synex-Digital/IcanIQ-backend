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
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('question.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Select Modeltest</label>
                                <select class="default-select  form-control wide" name="test_id">
                                    @foreach ($modeltests as $modeltest)
                                        <option value="{{ $modeltest->id }}">{{ $modeltest->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control" name="question_test"
                                    placeholder="Write Question Here..">
                            </div>
                            <div class="form-group mb-3 d-flex gap-5 justify-content-between">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Require</label>
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="1"
                                                    name="required">Compulsory
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="1"
                                                    name="status">Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Question</button>
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
                        <h5 class="modal-title">Edit Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('question.update', 'id') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id">
                            {{-- <div class="form-group mb-3">
                            <label class="form-label">Select Modeltest</label>
                            <select class="default-select  form-control wide" name="test_id">
                                @foreach ($modeltests as $modeltest)
                                <option value="{{ $modeltest->id }}">{{ $modeltest->title }}</option>
                               @endforeach
                            </select>
                        </div> --}}
                            <input type="hidden" name="test_id" id="test_id">
                            <div class="form-group mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control" id="question" name="question_test"
                                    placeholder="Write Question Here..">
                            </div>
                            <div class="form-group mb-3 d-flex gap-5 justify-content-between">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Require</label>
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input " value="1"
                                                    name="required">Compulsory
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <div class="mb-3">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value="1"
                                                    name="status">Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li> --}}
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
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
                        <h4 class="card-title">All Question List</h4>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#addclassmodal">+Add Question</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>Test Name</th>
                                        <th>Question</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Choice</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            <td>{{ $request->modeltest->title }}</td>
                                            <td>{{ $request->question_test }}</td>

                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="badge badge-xs light badge-{{ $request->required != 0 ? 'success' : 'warning' }} mr-1">
                                                        {{ $request->required != 0 ? 'Compulsory' : 'Optional' }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center"><span
                                                        class="badge badge-xs light badge-{{ $request->status != 0 ? 'success' : 'warning' }} mr-1">
                                                        {{ $request->status != 0 ? 'Active' : 'Deactive' }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button
                                                        class="badge badge-xs light badge-{{ $request->choices()->count() == 4 ? 'success' : 'warning' }} mr-1"
                                                        @if ($request->choices()->count() != 4) data-bs-container="body" data-bs-toggle="popover"
                                                        data-bs-placement="top"
                                                        data-bs-content="You have to add more then 4 question"
                                                        data-bs-original-title="Question Choice is missing" @endif>
                                                        {{ $request->choices()->count() }}
                                                    </button>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('questionchoice.show', $request->id) }}"
                                                        class="btn btn-success shadow btn-xs sharp me-1"
                                                        value="{{ $request->id }}"><i class="fa fa-eye"></i></a>
                                                    <button class="btn btn-warning shadow btn-xs sharp me-1 editbtn"
                                                        value="{{ $request->id }}"><i class="fa fa-pencil"></i></button>
                                                    <form action="{{ route('question.destroy', $request->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger shadow btn-xs sharp"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
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
                        $('#question').val(response.question_test);
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
