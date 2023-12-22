@extends('backend.index')
@section('content')

    <div class="container-fluid" >
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Test</a></li>
            </ol>
            <div class="text-end">
                <button onclick="printPage()" id="print" class=" btn btn-secondary text-white">Download</button>
            </div>
        </div>
        <!-- row -->
        <div class="row" id="print_view">
            <div class="col-12">
                <div class="card">
                        @foreach ($questions as $question)
                        <div class="card-header">
                        <h4>{{ $question->question_test_text }}</h4>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($question->choices as $sl => $choice)
                                    <li><span>{{ $sl + 1 }}. </span>{{ $choice->choice_text }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection
{{-- <script>
    function printPage() {
  window.print();
}
</script> --}}
<script>
    function printPage() {
        var printContent = document.getElementById("print_view").innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
