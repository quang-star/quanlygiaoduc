<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = ['name', 'certificate_id', 'min_score', 'max_score'];

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
    
}
