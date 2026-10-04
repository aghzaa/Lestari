<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'stories';

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'pendidikan',
        'kategori',
        'cerita',
        'motivation_text',
        'quote_text',
        'ip_address',
    ];

    protected $casts = [
        'umur' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
