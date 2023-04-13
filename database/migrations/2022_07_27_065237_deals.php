<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_deals', function(Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->references('id')->on('users');
            $table->string('contract_type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('document_uploaded')->nullable(); // did you
            $table->string('seller_buyer_affiliated')->nullable(); // are you
            $table->string('disclose_affiliated')->nullable(); // you must
            $table->string('list_price')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('closing_date')->nullable();
            $table->string('street_address_1')->nullable();
            $table->string('street_address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal')->nullable();
            $table->string('country')->nullable();
            $table->string('tenant_buyer_name')->nullable();
            $table->string('landlord_seller_name')->nullabe();
            $table->string('submission_id');
            $table->string('submission_path');
            $table->string('event_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commercial_deals');
    }
}
