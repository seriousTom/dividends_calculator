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
//    protected $appends = ['amount_after_taxes'];

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

//    public function getAmountAfterTaxesAttribute()
//    {
//        return $this->amount - $this->taxes_amount;
//    }

    public function scopeByFilters(Builder $builder, array $filters = [])
    {
        $builder->selectRaw('dividends.*, companies.name AS company_name, (dividends.amount - dividends.taxes_amount) AS amount_after_taxes')
            ->join('companies', 'companies.id', 'dividends.company_id');

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

        if(!empty($filters['start_month'])) {
            $builder->whereMonth('date', '>=', $filters['start_month']);
        }

        if(!empty($filters['end_month'])) {
            $builder->whereMonth('date', '<=', $filters['end_month']);
        }

        if(!empty($filters['date_from']) && empty($filters['date_to'])) {
            $builder->where('date', '>=', $filters['date_from']);
        } else if(empty($filters['date_from']) && !empty($filters['date_to'])) {
            $builder->where('date', '<=', $filters['date_to']);
        } else if(!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $builder->whereBetween('date', [$filters['date_from'], $filters['date_to']]);
        }

        if(!empty($filters['order_by']) && !empty($filters['order'])) {
            $builder->orderBy($filters['order_by'], $filters['order']);
        }

        return $builder;
    }

    public function scopeByPortfolio(Builder $builder, ?Portfolio $portfolio = null, array $filters): Builder
    {
        if (!empty($portfolio->id)) {
            $builder->where('portfolio_id', $portfolio->id);
        }

        if(!empty($filters['order_by']) && !empty($filters['order'])) {
            $builder->orderBy($filters['order_by'], $filters['order']);
        }

        return $builder;
    }
}
