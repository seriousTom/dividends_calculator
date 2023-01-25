<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';
    public $fillable = [
        'name',
        'user_id',
        'platform_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeByUserId(Builder $builder, int $userId): Builder
    {
        return $builder->where('user_id', $userId)->orderBy('name', 'asc');
    }
}
