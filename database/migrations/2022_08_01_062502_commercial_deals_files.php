<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CommercialDealsFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_deals_files', function(Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_deals_id')->references('id')->on('commercial_deals');
            $table->string('file_name');
            $table->string('file_url');
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
        Schema::dropIfExists('commercial_deals_files');
    }
}
