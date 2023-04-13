<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInformation extends Model
{
    use SoftDeletes;

    protected $table = 'user_information';

    protected $fillable = [
        'users_id',
        'first_name',
        'middle_name',
        'last_name',
        'street_address',
        'city',
        'state',
        'postal_code',
        'agent_license_number',
        'contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
