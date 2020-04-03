<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('birthday')->nullable()->after('password');
            $table->char('identity', 10)->nullable()->after('birthday');
            $table->dateTime('identity_date')->nullable()->after('identity');
            $table->char('identity_place', 255)->nullable()->after('identity_date');
            $table->char('phone_number', 11)->nullable()->after('identity_place');
            $table->char('current_address', 255)->nullable()->after('phone_number');
            $table->char('regularly_address', 255)->nullable()->after('current_address');
            $table->dateTime('join_company_date')->nullable()->after('regularly_address');
            $table->dateTime('company_staff_date')->nullable()->after('join_company_date');
            $table->integer('role')->after('company_staff_date');
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
            $table->dropColumn('birthday');
            $table->dropColumn('identity');
            $table->dropColumn('identity_date');
            $table->dropColumn('identity_place');
            $table->dropColumn('phone_number');
            $table->dropColumn('current_address');
            $table->dropColumn('regularly_address');
            $table->dropColumn('join_company_date');
            $table->dropColumn('company_staff_date');
            $table->dropColumn('role');
        });
    }
}
