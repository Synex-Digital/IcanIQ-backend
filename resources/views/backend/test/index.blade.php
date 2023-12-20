@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Test</a></li>
            </ol>
            <div class="text-end">
                <a href="{{ route('download.invoice', $models->first()->id) }}" class="d-block mb-1 print" data-id="{{ $models->first()->id }}">Download</a>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                        @foreach ($questions as $question)
                        <div class="card-header">
                        <h4>{{ $question->question_test_text }}</h4>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($questions->first()->choices as $sl=>$choice)
                                    <li><span>{{ $sl+1 }}. </span> {{ $choice->choice_text }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $('.print').on('click', function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            }
        });

        $.ajax({
            url: '/getprints',
            type: 'POST',
            data: {_token: CSRF_TOKEN, id: $(this).data('id')},
            success: function (data) {
                newWin = window.open("");
                newWin.document.write(data);
                newWin.document.close();
            }
        });
    });
</script>
