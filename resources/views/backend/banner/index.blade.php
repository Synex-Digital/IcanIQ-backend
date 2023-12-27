@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <!-- Add Order -->
        <div class="modal fade" id="addclassmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Banner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Banner</label>
                                <input type="file" class="form-control" name="banner">
                                <span style="color: #639ac3; font-size: 12px;">Image size: w-851, h-315</span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Banner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('modeltest.index') }}">Banner</a></li>
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
                        {{-- <h4 class="card-title">{{ $modeltests->title }}</h4> --}}
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#addclassmodal">+Add Banner</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 850px">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Banner</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $sl => $banner)
                                        <tr>
                                            <td>{{ $sl + 1 }}</td>
                                            <td><img style="width: 18rem"
                                                    src="{{ asset('files/banner') }}/{{ $banner->banner }}" alt="">
                                            </td>


                                            <td>
                                                <form action="{{ route('banner.destroy', $banner->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger shadow btn-xs sharp"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
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
