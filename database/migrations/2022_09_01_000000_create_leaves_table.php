<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->string('leaves_id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->string('category');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days');
            $table->string('reason')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('approved_date')->nullable(); 
            $table->string('status')->default('pending');
            $table->string('attachment')->nullable();
            $table->foreignUuid('approval')->nullable()->index();
        });

        Schema::table('leaves',function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
};
