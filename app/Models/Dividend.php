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
        'portfolio_id',
        'date'
    ];
    protected $appends = ['amount_after_taxes'];

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

    public function getAmountAfterTaxesAttribute()
    {
        return $this->amount - $this->taxes_amount;
    }

    public function scopeByFilters(Builder $builder, array $filters = [])
    {
        if(!empty($filters['user_id'])) {
            $builder->withoutGlobalScope(UserScope::class)->where('user_id', $filters['user_id']);
        }

        if(!empty($filters['portfolio_id'])) {
            $builder->where('portfolio_id', $filters['portfolio_id']);
        }

        if(!empty($filters['company_id'])) {
            $builder->where('company_id', $filters['company_id']);
        }

        if(!empty($filters['year'])) {
            $builder->whereYear('date', $filters['year']);
        }

        return $builder;
    }

    public function scopeByPortfolio(Builder $builder, ?Portfolio $portfolio = null): Builder
    {
        if (!empty($portfolio)) {
            $builder->where('portfolio_id', $portfolio->id);
        }

        return $builder;
    }
}
