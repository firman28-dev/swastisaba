<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionCourse extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id', 
        'name', 
        'description',
        'created_by',
        'updated_by',
        'id_survey',
        'is_active'
    ];

    protected $table = 'session_courses';

}
