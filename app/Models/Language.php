<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = ['code', 'name'];

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'language_id');
    }

    public function levels()
    {
        return $this->hasMany(Level::class, 'language_id');
    }
}
