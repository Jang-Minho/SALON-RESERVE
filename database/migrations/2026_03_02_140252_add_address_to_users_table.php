<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('name_sei');
            $table->string('name_mei');
            $table->string('name_sei_kana');
            $table->string('name_mei_kana');
            $table->string('gender');
            $table->date('birthdate');
            $table->string('postal_code');
            $table->string('prefecture');
            $table->string('city');
            $table->string('address_line');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn([
                'name_sei',
                'name_mei',
                'name_sei_kana',
                'name_mei_kana',
                'gender',
                'birthdate',
                'postal_code',
                'city',
                'address_line',
            ]);
        });
    }
};
