<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommercialDeals extends Model
{
    use SoftDeletes;

    protected $table = 'commercial_deals';

    protected $fillable = [
        'users_id',
        'contract_type',
        'transaction_type',
        'document_uploaded',
        'seller_buyer_affiliated',
        'disclose_affiliated',
        'list_price',
        'sale_price',
        'closing_date',
        'street_address_1',
        'street_address_2',
        'city',
        'state',
        'postal',
        'country',
        'tenant_buyer_name',
        'landlord_seller_name',
        'submission_id',
        'submission_path',
        'event_id'
    ];

    public function files() {
        return $this->hasMany(CommercialDealFiles::class, 'commercial_deals_id');
    }
}
