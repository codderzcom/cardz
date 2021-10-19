<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DepersonalizeInvite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invites', function(Blueprint $table) {
            $table->uuid('member_id')->nullable()->index();
            $table->uuid('inviter_id')->index();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invites', function(Blueprint $table) {
            $table->uuid('member_id')->nullable(false)->index();
            $table->dropColumn('inviter_id');
        });
    }
}
