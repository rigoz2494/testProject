<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrganisationContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisation_contact', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Organisation::class)->constrained('organisations');
            $table->foreignIdFor(\App\Models\Contact::class)->constrained('contacts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisation_contact');
    }
}
