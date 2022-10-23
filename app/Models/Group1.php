<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group1 extends Model
{
    use HasFactory;
    protected $table = 'group1';
    protected $guarded = [
        'id',
    ];
}