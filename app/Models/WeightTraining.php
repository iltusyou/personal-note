<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use App\Models\TrainingVolumn;
use App\Models\User;

class WeightTraining extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'default_weight',
        'user_id'
    ];    


}
