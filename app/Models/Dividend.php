<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    use HasFactory;

    protected $table = 'dividends';
    protected $fillable = [
        'amount',
        'taxes_amount',
        'currency_id',
        'user_id',
        'company_id',
        'date'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function scopeByPortfolioId(Builder $builder, ?int $portfolioId = null): Builder
    {
        if (!empty($portfolioId)) {
            $builder->where('portfolio_id', $portfolioId);
        }

        return $builder;
    }
}