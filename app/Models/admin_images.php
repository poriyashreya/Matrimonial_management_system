<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_images extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'Type_of_image',
    ];
}
