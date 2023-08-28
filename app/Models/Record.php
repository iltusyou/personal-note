<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WeightTraining;
use App\Models\WeightTrainingRecord;
use App\Models\User;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_date',
        'weight',
        'user_id'        
    ];    

    /**
     * Get all of the weightTrainingRecords for the Record
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function weightTrainingRecords(): HasMany
    {
        return $this->hasMany(WeightTrainingRecord::class);
    }

    /**
     * Get the user that owns the Record
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}
