<?php

namespace App\Http\Controllers;

// models
use App\Models\CommercialDeals;
use App\Models\CommercialDealFiles;
// end models
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// resource
use App\Http\Resources\GeneralResource;

class PropertyDealsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $limit = $request->get('limit');

        $query = CommercialDeals::query();
        if(!$request->boolean('is_admin')) {
            $query->where('users_id', auth()->user()->id);
        }
        
        return GeneralResource::collection($query->with('files')->paginate($limit));
    }

    public function store(Request $request)
    {
        Log::info($request->get('rawRequest'));
        $rawRequest = json_decode($request->get('rawRequest'), true);
        $commercialDeals = CommercialDeals::create([
            'users_id' => $rawRequest['q21_commercialUserId'],
            'contract_type' => $rawRequest['q14_chooseType'],
            'transaction_type' => $rawRequest['q15_transactionType17'],
            'document_uploaded' => $rawRequest['q13_didYou'],
            'seller_buyer_affiliated' => $rawRequest['q17_areYou'],
            'disclose_affiliated' => $rawRequest['q18_youMust'],
            'list_price' => $rawRequest['q11_listPrice'],
            'sale_price' => $rawRequest['q16_salePrice'],
            'closing_date' => $rawRequest['q6_closingDate']['month'].' '.$rawRequest['q6_closingDate']['day'].','.$rawRequest['q6_closingDate']['year'],
            'street_address_1' => $rawRequest['q7_propertyAddress']['addr_line1'],
            'street_address_2' => $rawRequest['q7_propertyAddress']['addr_line2'],
            'city' => $rawRequest['q7_propertyAddress']['city'],
            'state' => $rawRequest['q7_propertyAddress']['state'],
            'postal' => $rawRequest['q7_propertyAddress']['postal'],
            'country' => $rawRequest['q7_propertyAddress']['country'],
            'tenant_buyer_name' => $rawRequest['q8_tenantbuyerName'],
            'landlord_seller_name' => $rawRequest['q12_landlordsellerName'],
            'submission_id' => $rawRequest['slug'],
            'submission_path' => $rawRequest['path'],
            'event_id' => $rawRequest['event_id']
        ]);
        // save files if ever it has files submitted
        if(count($rawRequest['uploadAll']) > 0) {
            for($i=0; $i<count($rawRequest['uploadAll']); $i++) {
                CommercialDealFiles::create([
                    'commercial_deals_id' => $commercialDeals->id,
                    'file_name' => $rawRequest['temp_upload']['q10_uploadAll'][$i],
                    'file_url' => $rawRequest['uploadAll'][$i]
                ]);
            }
        }
        Log::info('Successfully recorded commercial deals data');
    }
}
