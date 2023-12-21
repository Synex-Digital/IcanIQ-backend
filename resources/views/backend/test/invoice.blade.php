@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Test</a></li>
            </ol>
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
    <script>
        function printInvoice() {
            window.print();
        }
        window.onload = printInvoice;
    </script>
@endsection

