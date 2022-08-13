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
        Schema::create('karateki', function (Blueprint $table) {
            $table->id();
            $table->char('name', 50);
            $table->char('patronymic', 50)->nullable();
            $table->char('surname', 50);
            $table->integer('qu')->nullable();
            $table->integer('dan')->nullable();
            $table->date('birthday')->nullable();
            $table->float('weight')->nullable();
            $table->bigInteger('coach_id')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->string('profile_role')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('contacts')->nullable();
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');
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
        Schema::dropIfExists('karateki');
    }
};
