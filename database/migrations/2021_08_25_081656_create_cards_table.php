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
            $table->uuid('plan_id')->index();
            $table->uuid('customer_id')->index();

            $table->string('description')->nullable();
            $table->dateTime('issued_at')->nullable()->index();
            $table->dateTime('satisfied_at')->nullable()->index();
            $table->dateTime('completed_at')->nullable()->index();
            $table->dateTime('revoked_at')->nullable()->index();
            $table->dateTime('blocked_at')->nullable()->index();
            $table->jsonb('achievements')->nullable();
            $table->jsonb('requirements')->nullable();

            $table->timestamp('created_at')->useCurrent()->index();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->index();
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
