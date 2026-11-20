<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doc_number',
        'type',
        'am_reference',
        'title',
        'category',
        'amount',
        'description',
        'status',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashAdvances()
    {
        return $this->hasMany(BudgetRequest::class, 'am_reference', 'doc_number');
    }

    public function latestCashAdvance()
    {
        return $this->hasOne(BudgetRequest::class, 'am_reference', 'doc_number')->latestOfMany();
    }
}
