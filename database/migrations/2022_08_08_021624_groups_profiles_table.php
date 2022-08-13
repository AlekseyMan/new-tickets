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
        Schema::create('groups_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->index();
            $table->unsignedBigInteger('profile_id')->index();

            $table->foreign('group_id')
                ->on('groups')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('profile_id')
                ->on('karateki')
                ->references('id')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups_profiles');
    }
};
