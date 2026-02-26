<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('buku_tamu', function (Blueprint $table) {
            $table->string('pekerjaan')->after('nama');
        });
    }

    public function down()
    {
        Schema::table('buku_tamu', function (Blueprint $table) {
            $table->dropColumn('pekerjaan');
        });
    }
};