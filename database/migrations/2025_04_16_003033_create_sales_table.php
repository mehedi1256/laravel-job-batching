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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('Region');
            $table->string('Country');
            $table->string('Item Type');
            $table->string('Sales Channel');
            $table->string('Order Priority');
            $table->string('Order Date');
            $table->string('Order ID');
            $table->string('Ship Date');
            $table->string('Units Sold');
            $table->string('Unit Price');
            $table->string('Unit Cost');
            $table->string('Total Revenue');
            $table->string('Total Cost');
            $table->string('Total Profit');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
