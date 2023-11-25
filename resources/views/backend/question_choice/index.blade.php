@extends('backend.index')
@section('content')
<div class="container-fluid">
    <!-- Add Order -->
    <div class="modal fade" id="addclassmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Question Choice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('questionchoice.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="choice_text" placeholder="Write Question Here.." value="{{ $question->question_test }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Set Option For Choice</label>
                            <input type="text" class="form-control" name="choice_text" placeholder="Write Question Here..">
                        </div>
                        <div class="form-group mb-3 d-flex gap-5 justify-content-between">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Require</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="1" name="is_correct">Right Answer
                                        </label>
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title">Edit Question Choice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('questionchoice.update', 'id') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="question_id" id="question_id">
                        <div class="form-group mb-3">
                            <label class="form-label">Set Option For Choice</label>
                            <input type="text" class="form-control" name="choice_text" id="choice_text" placeholder="Write Question Here..">
                        </div>
                        <div class="form-group mb-3 d-flex gap-5 justify-content-between">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Require</label>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" value="1" name="is_correct">Right Answer
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                    <h4 class="card-title">{{ $question->question_test }}</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addclassmodal">+Question Choice</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 850px">
                            <thead>
                                <tr>
                                    <th>Question's Option</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->choice_text }}</td>
                                    <td> <div class="d-flex align-items-center"><i class="fa fa-circle text-{{ $request->is_correct != 0 ? 'success':'warning' }} mr-1"></i> {{ $request->is_correct != 0 ? 'Right':'Wrong' }}</div></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-primary shadow btn-xs sharp me-1 editbtn" value="{{ $request->id }}"><i class="fa fa-pencil"></i></button>
                                            <form action="{{ route('question.destroy', $request->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
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
        $(document).ready(function(){
            $(document).on('click', '.editbtn', function(){
                var question_id = $(this).val();
                // alert(question_id);
               $('#editmodal').modal('show');

               $.ajax({
                type: "GET",
                url: "/questionchoice/"+question_id+"/edit",
                success: function(response){
                    console.log(response);
                    $('#choice_text').val(response.choice_text);
                    $('#question_id').val(response.question_id);
                    $('#id').val(response.id);
                }
               });
            })
        })
    </script>
@endsection