<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialDealFiles extends Model
{
    use SoftDeletes;

    protected $table = 'commercial_deals_files';

    protected $fillable = [
        'commercial_deals_id',
        'file_name',
        'file_url'
    ];
}
