<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'location', 'company_id', 'is_published'];

    public function company() {
      return $this->belongsTo(Company::class);
    }

    public function applications() {
      return $this->hasMany(Application::class);
    }
}
