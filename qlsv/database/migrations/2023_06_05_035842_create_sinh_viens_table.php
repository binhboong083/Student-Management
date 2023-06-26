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
        Schema::create('sinh_viens', function (Blueprint $table) {
            $table->id();
            $table->integer('mssv')->unique();
            $table->string('name');
            // $table->integer('class_id');
            // Tạo liên kết khóa ngoại
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('lop_quan_lies')->onDelete('cascade')->onUpdate('cascade');
            //
            $table->string('date');
            $table->integer('gender');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('thumb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinh_viens');
    }
};
