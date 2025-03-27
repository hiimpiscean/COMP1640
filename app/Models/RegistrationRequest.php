<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RegistrationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'requested_class_id',
        'status',
        'processed_by',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function requestedClass()
    {
        return $this->belongsTo(Classes::class, 'requested_class_id');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
