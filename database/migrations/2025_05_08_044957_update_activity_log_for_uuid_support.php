<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Drop the custom named indexes
            $table->dropIndex('subject');
            $table->dropIndex('causer');

            // Now let's change the column types to accommodate UUIDs
            $table->string('subject_id', 36)->nullable()->change();
            $table->string('causer_id', 36)->nullable()->change();

            // Recreate the indexes with the same custom names
            $table->index(['subject_id', 'subject_type'], 'subject');
            $table->index(['causer_id', 'causer_type'], 'causer');
        });
    }

    public function down()
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Drop the indexes
            $table->dropIndex('subject');
            $table->dropIndex('causer');

            // Change columns back to bigInteger (default for morphs)
            $table->unsignedBigInteger('subject_id')->nullable()->change();
            $table->unsignedBigInteger('causer_id')->nullable()->change();

            // Recreate the indexes
            $table->index(['subject_id', 'subject_type'], 'subject');
            $table->index(['causer_id', 'causer_type'], 'causer');
        });
    }
};
