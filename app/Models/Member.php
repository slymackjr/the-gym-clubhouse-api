<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name', 'role', 'phone_number', 'email', 'gender', 'height', 'weight','memo'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function accessLogs()
    {
        return $this->hasMany(DoorAccessLog::class);
    }
}
