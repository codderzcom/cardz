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
            $table->uuid('member_id')->nullable()->change();
            $table->uuid('inviter_id')->index();
        });

        Schema::table('invites', function(Blueprint $table) {
            $table->renameColumn('member_id', 'collaborator_id');
        });

        Schema::table('relations', function(Blueprint $table) {
            $table->index(['collaborator_id', 'workspace_id']);
            $table->unique(['collaborator_id', 'workspace_id']);
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
            $table->renameColumn('collaborator_id', 'member_id');
        });

        Schema::table('invites', function(Blueprint $table) {
            $table->uuid('member_id')->nullable(false)->change();
            $table->dropColumn('inviter_id');
        });

        Schema::table('relations', function(Blueprint $table) {
            $table->dropUnique(['collaborator_id', 'workspace_id']);
            $table->dropIndex(['collaborator_id', 'workspace_id']);
        });

    }
}
