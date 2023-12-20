<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modeltest;
use App\Models\Attempt;
use Carbon\Carbon;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Modeltest::all();
        return view('backend.requests.index', [
            'requests' => $requests,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        // dd($request->all());

        $data = Attempt::query();

        if ($request->has('status')) {
            if ($request->status != 'clear') {
                $data->where('status', $request->status);
            }
        } else {
            $data->where('status', 'pending');
        }


        $attempt = $data->where('model_id', $id)->get();

        return view('backend.attempt.index', [
            'attempt' => $attempt,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attemps = Attempt::find($id);
        return $attemps;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'      => 'required',
        ]);

        Attempt::where('id', $request->id)->update([
            'status'        => $request->status,
            'created_at'    => Carbon::now(),
        ]);
        return back()->with('succ', 'Panel Users Updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    function attempt_all(Request $request)
    {
        if ($request->btn == 1) {
            $attempts = Attempt::where('model_id', $request->model_id)->where('status', 'pending')->get();

            foreach ($attempts as $attempt) {
                $attempt->status = 'accept';
                $attempt->save();
            }
        } else {
            $attempts = Attempt::where('model_id', $request->model_id)->where('status', 'pending')->get();

            foreach ($attempts as $attempt) {
                $attempt->status = 'reject';
                $attempt->save();
            }
        }
        return back()->with('succ', 'Attempt Updated...');
    }
}
