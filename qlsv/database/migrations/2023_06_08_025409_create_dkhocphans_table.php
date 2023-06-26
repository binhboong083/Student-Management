<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dkhocphans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idsv');
            $table->unsignedBigInteger('idlop');
            // $table->primary(['idsv', 'idlop']);
            $table->timestamps();
            $table->foreign('idsv')->references('id')->on('sinh_viens')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idlop')->references('id')->on('lop_mon_hocs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dkhocphans');
    }
};
