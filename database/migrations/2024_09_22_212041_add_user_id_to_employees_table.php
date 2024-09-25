<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('employees', function (Blueprint $table) {
        // Add user_id foreign key
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        // Drop the foreign key and the column
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}

};
