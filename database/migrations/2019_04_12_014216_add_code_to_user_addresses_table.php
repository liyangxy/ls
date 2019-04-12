<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeToUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->char('province_code', 6)->nullable()->after('user_id');
            $table->char('city_code', 6)->nullable()->after('province_code');
            $table->char('district_code', 6)->nullable()->after('city_code');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('province_code');
            $table->dropColumn('city_code');
            $table->dropColumn('district_code');
            $table->dropColumn('deleted_at');
        });
    }
}
