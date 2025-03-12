<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'company_name',
        'company_email',
        'tin',
        'description',
        'address',
        'phone',
        'website',
        'founder',
        'manager',
        'account_name',
        'Account_number',
    ];
}
