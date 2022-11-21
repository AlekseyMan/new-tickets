<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('karateka_id');
            $table->unsignedBigInteger('coach_id');
            $table->foreign('karateka_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreign('coach_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->primary(['karateka_id','coach_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles_profiles');
    }
};
