<?php

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Exam
{
    //Return Value
    public static function TotalResultList($attempt_id)
    {
        $attempt = Attempt::find($attempt_id);

        $questions = Question::with('choices')->where('test_id', $attempt->model_id)->get();

        $userAnswers = Answer::where('attempt_id', $attempt->id)->get()->keyBy('question_id');

        $structuredData = collect();

        foreach ($questions as $question) {

            $correctChoice = null;

            if ($question->choices->where('is_correct', 1)->count() != 0) {
                $correctChoice = $question->choices->where('is_correct', 1)->first()->id;
            }

            $questionData = [
                'id'                    => $question->id,
                'test_id'               => $question->test_id,
                'question_test_text'    => $question->question_test_text,
                'question_test_image'   => $question->question_test_image != null ? asset('files/question/' . $question->question_test_image) : null,
                'required'              => $question->required,
                'status'                => $question->status,
                'created_at'            => $question->created_at,
                'updated_at'            => $question->updated_at,
                'correct_id'            => null,
                'wrong_id'              => null,
                'is_correct'            => false,
                'choices'               => $question->choices,
            ];

            if ($userAnswers->has($question->id)) {
                $userAnswer = $userAnswers[$question->id]; //geting answered

                $questionData['correct_id'] = $userAnswer->choice_id == $correctChoice ? $userAnswer->choice_id : null;
                $questionData['wrong_id'] = $userAnswer->choice_id;
                $questionData['is_correct'] = ($userAnswer->choice_id == $correctChoice);
            }

            $structuredData->push($questionData);
        }
        $data =  $structuredData->toArray();

        return $data;
    }

    //Giving The Result
    public static function GetResultCount($attemptId)
    {
        $totalResultData = self::TotalResultList($attemptId);
        $correctAndWrongCounts = self::CountCorrectAndWrongAnswers($totalResultData);

        // Count the total number of questions
        $totalQuestions = count($totalResultData);

        $modelTime = Attempt::find($attemptId);
        // Add the 'total_questions' field to the result counts
        $correctAndWrongCounts['total'] = $totalQuestions;
        $correctAndWrongCounts['time_taken'] = self::ExamTime($attemptId);
        $correctAndWrongCounts['exam_time'] = $modelTime ? $modelTime->model->exam_time : null;

        return $correctAndWrongCounts;
    }

    //Exam time taken
    public static function ExamTime($attempt)
    {

        $attempt = Attempt::find($attempt);

        if ($attempt) {
            $start_quiz = Carbon::parse($attempt->start_quiz);
            $end_quiz = Carbon::parse($attempt->end_quiz);

            if ($start_quiz && $end_quiz) {
                // Calculate the difference between start and end times
                $timeDifference = $start_quiz->diff($end_quiz);

                // Format the time difference as HH:MM:SS
                $examTime = $timeDifference->format('%H:%I:%S');

                return $examTime;
            }
        }

        return null;
    }

    public static function calculateAverageTime($id): string
    {
        $examDurations = Attempt::where('model_id', $id)->whereNot('status', 'reject')->get();

        $totalMinutes = 0;

        foreach ($examDurations as $examTime) {
            list($hours, $minutes, $seconds) = explode(':', $examTime);
            $totalMinutes += $hours * 60 + $minutes + $seconds / 60;
        }

        $averageMinutes = $totalMinutes / count($examDurations);

        return round($averageMinutes) . 'mn';
    }

    //Counting result
    private static function CountCorrectAndWrongAnswers($data)
    {
        $correctCount = 0;
        $wrongCount = 0;

        foreach ($data as $question) {
            if ($question['is_correct']) {
                $correctCount++;
            } else {
                $wrongCount++;
            }
        }

        return [
            'correct' => $correctCount,
            'wrong' => $wrongCount,
        ];
    }

    // private static function TotalResultListItem($attempt_id)
    // {
    //     $attempt = Attempt::find($attempt_id);

    //     $questions = Question::with('choices')->where('test_id', $attempt->model_id)->get();

    //     $userAnswers = Answer::where('attempt_id', $attempt->id)->get()->keyBy('question_id');

    //     $structuredData = collect();

    //     foreach ($questions as $question) {

    //         $correctChoice = null;

    //         if ($question->choices->where('is_correct', 1)->count() != 0) {
    //             $correctChoice = $question->choices->where('is_correct', 1)->first()->id;
    //         }

    //         $questionData = [
    //             'id'                    => $question->id,
    //             'test_id'               => $question->test_id,
    //             'question_test_text'    => $question->question_test_text,
    //             'question_test_image'   => $question->question_test_image != null ? asset('files/question/' . $question->question_test_image) : null,
    //             'required'              => $question->required,
    //             'status'                => $question->status,
    //             'created_at'            => $question->created_at,
    //             'updated_at'            => $question->updated_at,
    //             'correct_id'            => null,
    //             'wrong_id'              => null,
    //             'is_correct'            => false,
    //             'choices'               => $question->choices,
    //         ];

    //         if ($userAnswers->has($question->id)) {
    //             $userAnswer = $userAnswers[$question->id]; //geting answered

    //             $questionData['correct_id'] = $userAnswer->choice_id == $correctChoice ? $userAnswer->choice_id : null;
    //             $questionData['wrong_id'] = $userAnswer->choice_id;
    //             $questionData['is_correct'] = ($userAnswer->choice_id == $correctChoice);
    //         }

    //         $structuredData->push($questionData);
    //     }
    //     $data =  $structuredData->toArray();

    //     return $data;
    // }

    public static function avarageInfo($id)
    {
        try {
            $attempts = Attempt::select('id')
                ->where('user_id', $id)
                ->whereIn('status', ['result', 'done'])
                ->get();

            $totalTest = $attempts->count();

            if ($totalTest === 0) {
                throw new \Exception("No test data available for this user.");
            }

            $avScore = null;
            $avTime = null;

            foreach ($attempts as $key => $attempt) {
                $data = Exam::GetResultCount($attempt->id);
                $attempt['x'] = $data;
                $avScore += $data['correct'];
                $timeTaken = $data['time_taken'];

                if ($timeTaken) {
                    $timeParts = explode(':', $timeTaken);
                    $hours = (int)$timeParts[0];
                    $minutes = (int)$timeParts[1];
                    $seconds = (int)$timeParts[2];
                    $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

                    $avTime += $totalSeconds;
                }
            }

            $score = $avScore / $totalTest; // average score

            $averageTimeSeconds = $avTime / $totalTest;

            $averageHours = floor($averageTimeSeconds / 3600);
            $averageMinutes = floor(($averageTimeSeconds % 3600) / 60);
            $averageSeconds = $averageTimeSeconds % 60;

            $averageTime = sprintf("%02d:%02d:%02d", $averageHours, $averageMinutes, $averageSeconds);

            return [
                'total_test' => $totalTest,
                'av_score' => number_format($score, 2),
                'av_time' => $averageTime,
            ];
        } catch (\Exception $e) {
            // Handle the exception here, you can log the error or return a specific response.
            return [
                'total_test' => 0,
                'av_score'  => 0,
                'av_time'   => 0,
                'error'     => $e->getMessage(),
            ];
        }
        // $attempt = Attempt::select('id')->where('user_id', $id)->whereIn('status', ['result', 'done'])->get();

        // $totalTest = $attempt->count();

        // $avScore = null;
        // $avTime = null;

        // foreach ($attempt as $key => $value) {
        //     $data = Exam::GetResultCount($value->id);
        //     $value['x'] = $data;
        //     $avScore += $data['correct'];
        //     $timeTaken = $data['time_taken'];

        //     if ($timeTaken) {
        //         # code...
        //         $timeParts = explode(':', $timeTaken);
        //         $hours = (int)$timeParts[0];
        //         $minutes = (int)$timeParts[1];
        //         $seconds = (int)$timeParts[2];
        //         $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

        //         $avTime += $totalSeconds;
        //     }
        // }

        // $score = $avScore / $totalTest; //avarage score

        // $averageTimeSeconds = $avTime / $totalTest;

        // $averageHours = floor($averageTimeSeconds / 3600);
        // $averageMinutes = floor(($averageTimeSeconds % 3600) / 60);
        // $averageSeconds = $averageTimeSeconds % 60;

        // $averageTime = sprintf("%02d:%02d:%02d", $averageHours, $averageMinutes, $averageSeconds);


        // return [
        //     'total_test' => $totalTest,
        //     'av_score' => number_format($score, 2),
        //     'av_time' => $averageTime,
        // ];
    }
}
