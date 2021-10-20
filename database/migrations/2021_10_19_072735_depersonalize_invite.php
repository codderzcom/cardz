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
            $table->dropColumn('accepted_at');
            $table->dropColumn('member_id');
            $table->uuid('inviter_id')->index();
        });

        Schema::table('relations', function(Blueprint $table) {
            $table->index(['collaborator_id', 'workspace_id']);
            $table->unique(['collaborator_id', 'workspace_id']);
            $table->dropColumn('left_at');
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
            $table->dateTime('accepted_at')->nullable()->index();
            $table->uuid('member_id')->index();
            $table->dropColumn('inviter_id');
        });

        Schema::table('relations', function(Blueprint $table) {
            $table->dropUnique(['collaborator_id', 'workspace_id']);
            $table->dropIndex(['collaborator_id', 'workspace_id']);
            $table->dateTime('left_at')->nullable()->index();
        });

    }
}
