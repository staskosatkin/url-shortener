<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUrlModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE SCHEMA application");

        Schema::create('application.urls', function (Blueprint $table) {
            $table->id();
            $table->string('hash', 6)->index('idx_hash');
            $table->string('original_url', 512);
            $table->dateTime('expiration_date')->nullable();
            $table->string('custom_alias', 10)->nullable();
            $table->unsignedBigInteger('user_id');

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
        Schema::drop('urls');
    }
}
