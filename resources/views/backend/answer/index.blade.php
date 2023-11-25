@extends('backend.index')
@section('content')
<div class="container-fluid">
    <!-- Add Order -->
    <div class="modal fade" id="addclassmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Answer Choice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('questionchoice.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Select Question</label>
                            <select class="default-select  form-control wide questionclick" name="question_id">
                                @foreach ($questions as $questions)
                                <option value="{{ $questions->id }}">{{ $questions->question_test }}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            {{-- <label class="form-label">Select Answer</label>
                            <select class="default-select  form-control wide" name="options"> --}}
                               
                            </select>
                            <div class="mb-3 mb-0 ">
                                <div class="form-check ">
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                  <label class="form-check-label" for="flexRadioDefault3">
                                     Option 3
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                                  <label class="form-check-label" for="flexRadioDefault3">
                                     Option 3
                                  </label>
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
    {{-- <div class="modal fade" id="editmodal">
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
    </div> --}}


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
                    <h4 class="card-title">All Answer List</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addclassmodal">+Question Choice</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 850px">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $request->question_id }}</td>
                                    <td>{{ $request->choice_id }}</td>
                                    {{-- <td>
                                        <div class="d-flex">
                                            <button class="btn btn-primary shadow btn-xs sharp me-1 editbtn" value="{{ $request->id }}"><i class="fa fa-pencil"></i></button>
                                            <form action="{{ route('question.destroy', $request->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>												
                                    </td>												 --}}
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<script type="text/javascript">
    $("document").ready(function () {
        $('select[name="question_id"]').on('change', function () {
            var qId = $(this).val();
            alert(qId);
            if (qId) {
                $.ajax({
                    url: '/getanswer/' + qId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        $('select[name="options"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="options"]').append('<option value=" ' + key + '">' + value + '</option>');
                        })
                    }

                })
            } else {
                $('select[name="question_id"]').empty();
            }
        });


    });
</script>
@endsection