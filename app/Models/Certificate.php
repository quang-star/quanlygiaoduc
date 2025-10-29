<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = ['language_id', 'code', 'name'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }

    public function entranceExams()
    {
        return $this->hasOne(EntranceExam::class, 'certificate_id');
    }

    public function studentProfiles()
    {
        return $this->hasMany(StudentProfile::class);
    }
}
