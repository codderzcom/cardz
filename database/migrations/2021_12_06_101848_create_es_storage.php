<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEsStorage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('es_storage', function (Blueprint $table) {
            $table->id();

            $table->string('channel')->index();
            $table->string('name')->index();
            $table->uuid('stream')->index();
            $table->integer('version')->index();
            $table->dateTime('at')->index();
            $table->jsonb('changeset');

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
        Schema::dropIfExists('es_storage');
    }
}
