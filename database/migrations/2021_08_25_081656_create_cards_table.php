<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('plan_id')->index();
            $table->string('customer_id')->index();

            $table->string('description')->nullable();
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->dateTime('blocked_at')->nullable();
            $table->jsonb('achievements')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
