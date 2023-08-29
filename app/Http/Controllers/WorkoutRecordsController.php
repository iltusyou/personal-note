<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Record;
use App\Models\WeightTraining;
use App\Models\TrainingVolume;
use App\Models\WeightTrainingRecord;

class WorkoutRecordsController extends Controller
{
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $user = Auth()->user();    
            $recordIds = Record::where('user_id', $user->id)
            ->get()
            ->map(function($e){ 
                return $e->id; 
            });

            $weightTrainingRecords = WeightTrainingRecord::with(['record','trainingVolumns'])
            ->whereIn('record_id', $recordIds)->get();

            $data = $weightTrainingRecords->map(function($e){ 
                return [ 
                    'date' => $e->record->record_date,
                    'name' => $e->weightTraining -> name, 
                    'weightTrainingId' => $e -> weightTraining -> id,
                    'trainingVolumns' => $e->trainingVolumns ]; 
            });        

            $sorted = $data->sortByDesc('date');
            $sorted = $sorted->values()->all();

            return response()->json(['status' => true, 'data' => $sorted], 200);
        }
        catch(Exception $e){
            Log::error($e.getmessage());
            return response()->json(['status' => false, 'message' => 'serve error'], 500);
        }
    }
}
