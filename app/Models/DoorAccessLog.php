<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoorAccessLog extends Model
{
    use HasFactory;

    protected $table = "door_access_logs";
    protected $fillable = ['user_id', 'access_time', 'access_point'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
