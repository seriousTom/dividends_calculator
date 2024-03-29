<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platforms';
    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeAvailable(Builder $builder, int $userId): Builder
    {
        return $builder->where('user_id', $userId)->orWhereNull('user_id')->orderBy('name', 'asc');
    }

    public function scopeByUserId(Builder $builder, int $userId): Builder
    {
        return $builder->where('user_id', $userId)->orderBy('name', 'asc');
    }

    public function belongsToUser(User $user)
    {
        return $this->user_id == $user->id;
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class, 'platform_id', 'id');
    }

    public function hasPortfolios()
    {
        return $this->portfolios->count() > 0;
    }
}
