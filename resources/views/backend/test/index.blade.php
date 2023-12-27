@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Test</a></li>
            </ol>
            <div class="text-end">
                <a href="{{ route('result.download', $id) }}" id="print"
                    class=" btn btn-secondary text-white">Download</a>
            </div>
        </div>
        <div class="row px-3">
            <div class="card">
                <div class="card-body">
                    <form method="get">
                        <div class="col-12 col-md-8 d-flex gap-4">
                            <select class="form-control" name="filter" id="">
                                <option value="">All</option>
                                <option value="true">Correct Answer</option>
                                <option value="false">Wrong Answer</option>
                            </select>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row" id="print_view">
            <div class="col-12">
                <div class="card">
                    @foreach ($questions as $key => $question)
                        <div class="card-header">
                            <h4>
                                <span>{{ $key + 1 }}.</span>
                                <span class="text-{{ $question['is_correct'] ? 'success' : 'danger' }}">
                                    {{ $question['question_test_text'] }}</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <ul>
                                <div class="row gap-2">
                                    @foreach ($question['choices'] as $sl => $choice)
                                        <li
                                            class="col-6 px-3 py-2 border rounded 
                                    @php
if (!$question['is_correct']) {
                                            if ($question['wrong_id'] == $choice['id']) {
                                                echo "text-white bg-danger";
                                            } elseif ($choice['is_correct'] == 1) {
                                                echo "bg-success text-white";
                                            } else {
                                                echo "text-black";
                                            }
                                        } else {
                                            if ($question['correct_id'] == $choice['id']) {
                                                echo "bg-success text-white";
                                            } else {
                                                echo "text-black";
                                            }
                                        } @endphp
                                ">
                                            <span>{{ $sl + 1 }}.</span>{{ $choice['choice_text'] }}
                                        </li>
                                    @endforeach
                                </div>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
