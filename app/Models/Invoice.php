<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";

    protected $fillable = [
        'user_name',
        'user_phone',
        'user_email',
        'member_name',
        'member_id',
        'member_phone',
        'amount_paid',
        'status',
        'paid',
        'memo',
        'package_name',
        'discount_percentage',
        'start_date',
        'end_date'
    ];

    public function member()
{
    return $this->belongsTo(Member::class);
}

}
