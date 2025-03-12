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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // User information
            $table->string('user_name');
            $table->string('user_phone');
            $table->string('user_email');
            
            // Member information
            $table->foreignId('member_id')->constrained('members') ->onDelete('cascade');
            $table->string('member_name');
            $table->string('member_phone');
            $table->decimal('amount_paid', 20, 2);
            $table->string('status'); 
            $table->boolean('paid')->default(true);
            
            // Package and discount details
            $table->string('package_name');
            $table->decimal('discount_percentage', 5, 2)->nullable();
            
            // Dates
            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->string("invoice_file")->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropColumn('member_id');  
        });
        Schema::dropIfExists('invoices');
    }
};
