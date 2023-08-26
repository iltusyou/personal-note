<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WeightTraining;
use App\Models\User;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_date',
        'weight',
        'user_id'        
    ];

    public function weight_traings(){
        return $this->belongsToMany(WeightTraining);
    }

    public function user(){
        return $this->belongsTo(User);
    }
}
