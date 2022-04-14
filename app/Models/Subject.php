<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'major_id',
        'major_name',
        'year_of_study',
        ];

    public function files() {
        return $this->hasMany(File::class);
    }
}
