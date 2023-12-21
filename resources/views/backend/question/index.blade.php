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
                        <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Select Modeltest</label>
                                <select class="default-select  form-control wide" name="test_id">
                                    <option value="{{ $modeltests->id }}" @readonly(true)>{{ $modeltests->title }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control" name="question_test_text"
                                    placeholder="Write Question Here..">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Question Image</label>
                                <input type="file" class="form-control" name="question_test_image">
                            </div>
                            <hr>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>Choices</div>
                                    <a class="btn btn-xs btn-dark" id="createChoice">+</a>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="choices-container">
                                        <div class="d-flex mb-2 choice" id="choice">
                                            <input type="text" class="form-control" name="choice[]"
                                                placeholder="Write Question Here.." required>
                                            <input type="radio" style="margin-left: 5px" name="check" required
                                                id="">
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
                        <form action="{{ route('question.update', 'id') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="test_id" id="test_id">
                            <div class="form-group mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control" id="question_test_text" name="question_test_text"
                                    placeholder="Write Question Here..">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Question Image</label>
                                <input type="file" class="form-control" id="question_test_image"
                                    name="question_test_image" placeholder="Write Question Here..">
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
                <li class="breadcrumb-item"><a href="{{ route('modeltest.index') }}">Model</a></li>
                <li class="breadcrumb-item active"><a href="#">{{ $modeltests->title }}</a></li>
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
                        <h4 class="card-title">{{ $modeltests->title }}</h4>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#addclassmodal">+Add Question</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Question</th>
                                        <th>Question Image</th>
                                        <th>Status</th>
                                        <th>Choice</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $sl => $request)
                                        <tr>
                                            <td>{{ $sl + 1 }}</td>
                                            <td>{{ $request->question_test_text }}</td>
                                            <td><img width="60px"
                                                    src="{{ asset('files/question') }}/{{ $request->question_test_image }}"
                                                    alt=""></td>

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
                        $('#question_test_text').val(response.question_test_text);
                        $('#question_test_image').val(response.question_test_image);
                        $('#test_id').val(response.test_id);
                        $('#id').val(response.id);
                    }
                });
            })

            var choiceCounter = 0; // Counter for radio button values

            $('#createChoice').on('click', function() {
                choiceCounter++;
                var newChoice = $('.choice').first().clone(); // Clone the choice element
                newChoice.find('input[type="text"]').val('');
                newChoice.find('input[name="check"]').val(choiceCounter); // Update the radio button value
                $('.choices-container').append(newChoice); // Append the cloned choice to the container
                console.log(newChoice);
            });
        })
    </script>
    <script>
        $(function() {
            $('[data-bs-toggle="popover"]').popover()
        })
    </script>
@endsection
