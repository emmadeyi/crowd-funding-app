<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserIdentityDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_identity_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('dob');
            $table->enum('gender', ['M', 'F', 'U'])->default('U'); //U - unknow
            $table->enum('marital_status', ['S', 'M', 'D', 'U'])->default('U');
            $table->string('nationality')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('NIN')->nullable();
            $table->string('qualification')->nullable();
            $table->string('passport_photo')->nullable();
            $table->string('id_card')->nullable();
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
        Schema::dropIfExists('user_identity_details');
    }
}
