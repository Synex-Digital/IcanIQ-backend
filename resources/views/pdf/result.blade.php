<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Result - {{ $model->rel_user->name }}</title>
    <style>
        /* Raw CSS Styles */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 16px;
        }

        .container-fluid {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .card {
            margin-bottom: 15px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #f7f7f9;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        .row.gap-2>* {
            flex: 0 0 50%;
            max-width: 50%;
            padding-right: 5px;
            padding-left: 5px;
        }

        .px-3 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .border {
            border: 1px solid #dee2e6;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .text-white {
            color: #fff;
        }

        .text-black {
            color: #000;
        }

        .bg-success {
            background-color: #28a745;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div style="text-align: center; margin-bottom: 1rem">
                <h2>iCAN-IQ</h2>
                <h4>{{ $model->model->title }}</h4>
                <p>Name : {{ $model->rel_user->name }}</p>
            </div>
            <div>
                <table style="width:100%">
                    <tr>
                        <th>Correct Answer</th>
                        <th>Wrong Answer</th>
                        <th>Total Question</th>
                        <th>Time Taken</th>
                        <th>Exam Time</th>
                    </tr>
                    <tr style="text-align: center">
                        <td>{{ $history['correct'] }}</td>
                        <td>{{ $history['wrong'] }}</td>
                        <td>{{ $history['total'] }}</td>
                        <td>{{ $history['time_taken'] }}</td>
                        <td>{{ $history['exam_time'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-12">
                <div>
                    @foreach ($questions as $key => $question)
                        <div>
                            <h4>
                                <span>{{ $key + 1 }}.</span>
                                <span class="text-{{ $question['is_correct'] ? 'success' : 'danger' }}">
                                    {{ $question['question_test_text'] }}</span>
                            </h4>
                        </div>
                        <div style="margin-bottom: 1rem">
                            <ul>
                                <div class="row gap-2">
                                    @foreach ($question['choices'] as $sl => $choice)
                                        <li class="col-6 px-3 py-2 border rounded
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
                                "
                                            style="margin-bottom: 4px">
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
</body>

</html>
