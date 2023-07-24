<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
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

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function platform()
    {
        return $this->belongsTo(Portfolio::class, 'platform_id', 'id');
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'portfolio_id', 'id');
    }

    public function scopeByUserId(Builder $builder, int $userId): Builder
    {
        return $builder->where('user_id', $userId)->orderBy('name', 'asc');
    }
}
