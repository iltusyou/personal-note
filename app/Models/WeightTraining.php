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

    public function records(){
        return $this->belongsToMany(Record);
    }

    /**
     * Get all of the comments for the WeightTraining
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trainingVolumns()
    {
        return $this->hasMany(TrainingVolumn);
    }
}
