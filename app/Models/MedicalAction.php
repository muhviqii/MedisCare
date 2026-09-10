<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalAction extends Model
{
    use HasFactory;

    protected $fillable = ['medical_record_id', 'action_name', 'description', 'cost', 'performed_by', 'performed_at'];

    protected function casts(): array
    {
        return ['performed_at' => 'datetime'];
    }

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
