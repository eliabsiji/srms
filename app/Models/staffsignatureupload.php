<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staffsignatureupload extends Model
{
    use HasFactory;
    protected $table = "staffsignatureupload";
   // protected $primaryKey = "studentid";

    protected $fillable = [
        'staffid',
        'signature',
    ];
}
