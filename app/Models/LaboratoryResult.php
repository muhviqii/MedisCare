<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaboratoryResult extends Model
{
    use HasFactory;

    protected $fillable = ['laboratory_order_id', 'parameter_name', 'result_value', 'normal_value', 'unit', 'notes', 'recorded_by'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(LaboratoryOrder::class, 'laboratory_order_id');
    }
}
