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
        Schema::create('amount_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('amount');
            $table->foreignId('voucher_id')
                ->references('id')
                ->on('vouchers')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amount_history', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
        });

        Schema::dropIfExists('amount_history');
    }
};
