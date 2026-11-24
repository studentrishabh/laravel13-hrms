<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class Employee extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'gender',
        'department',
        'designation',
        'salary',
        'joining_date',
        'photo',
        'status',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}
