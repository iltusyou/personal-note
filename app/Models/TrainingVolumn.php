<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WeightTraining;

class TrainingVolumn extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the TrainingVolumn
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function weightTraining(): BelongsTo
    {
        return $this->belongsTo(WeightTraining);
    }
}
