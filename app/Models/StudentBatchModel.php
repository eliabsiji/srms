<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentBatchModel extends Model
{
    use HasFactory;

    protected $table = "student_batch_upload";


    protected $fillable = [
        'title',
        'studentid',
        'schoolclassid',
        'termid',
        'sessionid',
        'status',
    ];

}
