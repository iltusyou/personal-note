<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Record;
use App\Models\TrainingVolumn;

class WeightTrainingRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'record_id',
        'weight_training_id'        
    ];  

    /**
     * Get the record that owns the WeightTrainingRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function record():BelongsTo
    {
        return $this->belongsTo(Record::class);
    }

    /**
     * Get all of the trainingVolumns for the WeightTrainingRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trainingVolumns()
    {
        return $this->hasMany(TrainingVolumn::class);
    }
}
