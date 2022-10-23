<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group2 extends Model
{
    use HasFactory;
    protected $table = 'group2';
    protected $guarded = [
        'id',
    ];
}