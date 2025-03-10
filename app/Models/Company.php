<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = [
        'name',
        'ticker',
        'sector_id',
        'industry_id',
        'user_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new UserScope);
    }

    public function scopeWithDividendSum(Builder $builder, int $userId, ?int $year = null): Builder
    {
        $builder = $builder->selectRaw('companies.*, SUM(dividends.amount) AS dividends_sum')->leftJoin('dividends', 'dividends.company_id', 'companies.id')
            ->where('dividends.user_id', $userId);

        if (!empty($year)) {
            $builder = $builder->whereYear('date', $year);
        }

        return $builder->groupBy('companies.id');
    }

    public function scopeByRequest(Builder $builder, array $request): Builder
    {
        if (!empty($request['name'])) {
            $builder = $builder->whereAny([
                'name',
                'ticker',
            ], 'like', '%' . $request['name'] . '%');
        }

        if (!empty($request['company_id'])) {
            $builder = $builder->where('id', $request['company_id']);
        }

        return $builder;
    }
}
