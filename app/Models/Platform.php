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

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where(function($q) {
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
