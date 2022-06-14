<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineMaintenanceFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_maintenance_fees', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('transaction_id');
            $table->integer('user_id');
            $table->integer('amount_paid');
            $table->boolean('status')->default(0);
            $table->enum('confirmation', ['0','1','2'])->default('1'); //0 - declined, 1 - pending, 2 - confirmed
            $table->timestamp('renewal_date')->nullable();
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
        Schema::dropIfExists('routine_maintenance_fees');
    }
}
