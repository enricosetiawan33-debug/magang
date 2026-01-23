<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;
    protected $table = 'lowongan';
	

    protected $fillable = [
        'title', 
        'division', 
        'level', 
        'quota', 
        'deadline', 
        'description',
		'requirements',		
        'is_active'
    ];
	protected $casts = ['level' => 'array',
'deadline' => 'date',
'is_active' => 'boolean',];

}
