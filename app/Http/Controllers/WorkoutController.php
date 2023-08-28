<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;

use App\Models\Record;
use App\Models\WeightTraining;
use App\Models\TrainingVolume;
use App\Models\WeightTrainingRecord;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class WorkoutController extends Controller
{    
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
    public function getRecord($date): \Illuminate\Http\JsonResponse
    {              
        //Log::info($date);           
        $user = Auth()->user();

        //$date = Carbon::parse($date+' 00:00:00');
        $records = Record::with('weightTrainingRecords.trainingVolumns')->
        where('user_id', $user->id)->whereDate('record_date', $date);
        $record = $records->first();
        Log::info($record);
        return response()->json(['status' => true, 'data' => $record], 200);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try{
            $user = Auth()->user();
            $date = Carbon::parse($request->recordDate)->setTimezone('Asia/Taipei');

            $record = Record::where('user_id', $user->id)->where('record_date', $date);
            // if ($record->first()) {
            //     return update($request);
            // }
            $req = $request->all();                                

            $record = new Record();
            $record->user_id=$user->id;
            $record->weight=$req['weight'];
            $record->record_date= $date;
            $record->save();

            foreach ($req['weightTrainings'] as $weightTrainingItem){                               
                $weightTrainingRecord = $record->weightTrainingRecords()->create([
                    'weight_training_id'=> $weightTrainingItem['name']
                ]);                      
                
                foreach($weightTrainingItem['trainingVolumes'] as $training_volumnsItem){
                    $weightTrainingRecord -> trainingVolumns()->create([
                        'load' =>  $training_volumnsItem['load'],
                        'repetitions' => $training_volumnsItem['repetitions']
                    ]);
                }
            }
            DB::commit();
            return response()->json(['status' => true, 'data' => $record], 201);
        }
        catch(Exception $e){
            DB::rollBack();
            Log::error($e.getmessage());
            return response()->json(['status' => false, 'message' => 'serve error'], 500);
        }
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {         
        $req = $request->all();
        $req['record_date']= $date;
        Log::info($req);

        // $carbon = new Carbon($req['record_date'], 'Asia/Taipei');
        // Log::info($carbon);

        return response()->json(['status' => true, 'data' => $req]);
    }

    public function getWeightTrainings(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();        
        $data = WeightTraining::where('user_id', $user->id)->get();  
        return response()->json(['status' => true, 'data' => $data]);
    }

    public function addWeightTraining(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();
        $req = $request->all();
        $req['user_id'] = $user->id;
        $data = WeightTraining::create($req);

        return response()->json(['status' => true, 'data' => $req], 200);
    }

    public function updateWeightTraining(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth()->user();

        $data = WeightTraining::find($request->id);
        $data->name = $request->name;
        $data->default_weight = $request->default_weight;
        $data->update();        
        
        return response()->json(['status' => true, 'data' => $data], 200);
    }
}
