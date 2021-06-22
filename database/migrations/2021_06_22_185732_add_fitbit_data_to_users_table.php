<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFitbitDataToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('fitbit_client_id')->nullable();
            $table->string('fitbit_client_secret')->nullable();
            $table->text('fitbit_access_token')->nullable();
            $table->text('fitbit_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('fitbit_client_id');
            $table->dropColumn('fitbit_client_secret');
            $table->dropColumn('fitbit_access_token');
            $table->dropColumn('fitbit_refresh_token');
        });
    }
}
