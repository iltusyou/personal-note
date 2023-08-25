<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use App\Models\Record;


class WorkoutController extends Controller
{
    public function index(Request $request){
        return Jetstream::inertia()->render($request, 'Workout/Index');
    }

    public function edit(Request $request, $id=0){
        return Jetstream::inertia()->render($request, 'Workout/Edit', ['id'=> $id]);
    }

    public function getRecords(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();
        sleep(3);
        $data = Record::query()->where('user_id', $user->id)->get();
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * getRecord
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecord($id): \Illuminate\Http\JsonResponse
    {
        $data=Record::findOrFail($id);
        return response()->json($data, 200);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();


        $data = Record::where('user_id', $user->id)->where('record_date', $request->record_date);
        if ($data->first()) {
            return response()->json(['status' => false, 'message' => 'Already exist']);
        }
        $req = $request->all();
        $req['user_id'] = $user->id;
        $data = Record::create($req);
        return response()->json(['status' => true, 'data' => $data], 201);
    }
}
