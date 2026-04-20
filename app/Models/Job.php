<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'description', 'location', 'salary', 'company_id', 'is_published'];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function company() {
      return $this->belongsTo(Company::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

    /**
     * Unpublished jobs belonging to companies whose linked user is an employer (role company).
     */
    public function scopePendingEmployerOwned(Builder $query): Builder
    {
        return $query
            ->where('is_published', false)
            ->whereHas('company.user', function (Builder $q) {
                $q->where('role', 'company');
            });
    }
}
