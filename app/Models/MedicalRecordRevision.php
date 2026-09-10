<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecordRevision extends Model
{
    public $timestamps = false;
    protected $fillable = ['medical_record_id', 'changed_by', 'previous_data', 'new_data', 'created_at'];

    protected function casts(): array
    {
        return ['previous_data' => 'array', 'new_data' => 'array', 'created_at' => 'datetime'];
    }

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
