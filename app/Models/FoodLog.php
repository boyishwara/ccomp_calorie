<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodLog extends Model
{
    protected $fillable = [
        'name',
        'calories',
        'consumed_at',
        'meal_type',
    ];

    protected function casts(): array
    {
        return [
            'consumed_at' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
