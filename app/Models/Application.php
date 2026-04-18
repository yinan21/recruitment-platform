<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'job_id',
        'candidate_id',
        'cover_letter',
        'cv_path',
    ];

    public function job() {
      return $this->belongsTo(Job::class);
    }

    public function candidate() {
      return $this->belongsTo(User::class, 'candidate_id');
    }
}
