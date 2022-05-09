<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Conner\Likeable\Likeable;

class File extends Model
{
    use HasFactory, Likeable;

    protected $fillable = [
        'generated_file_name',
        'user_file_name',
        'description',
        'is_public',
        'file_type',
        'file_size',
        'user_id',
        'subject_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function checkLike(array $likes)
    {
        foreach ($likes as $like) {
            if ($like->user_id == auth()->user()->id) {
                return true;
            }
        }
        return false;
    }
}
