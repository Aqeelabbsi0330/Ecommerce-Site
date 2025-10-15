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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->timestamps();
        });
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid', 'shipped'])->default('pending');
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
        Schema::create('user_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jti', 255);                     // varchar(255)
            $table->string('token')->unique();
            $table->timestamp('expires_at');

            // Extra attributes
            $table->string('device_type')->default('web');  // default web
            $table->string('ip_address', 255);              // varchar(255)

            $table->timestamps();
        });
        Schema::create('user_refresh_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jti', 255);                     // varchar(255)
            $table->string('token')->unique();
            $table->timestamp('expires_at');

            // Extra attributes
            $table->string('device_type')->default('web');  // default web
            $table->string('ip_address', 255);              // varchar(255)

            $table->timestamps();
        });
        Schema::create('blacklisted_access_tokens', function (Blueprint $table) {
            $table->id();
            // Foreign key to users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jti', 255);  // jti field

            $table->string('token')->unique();

            $table->timestamps();
        });
        Schema::create('blacklisted_refresh_tokens', function (Blueprint $table) {
            $table->id();
            // Foreign key to users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jti', 255); // jti field
            $table->string('token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('user_access_tokens');
        Schema::dropIfExists('user_refresh_tokens');
        Schema::dropIfExists('blacklisted_access_tokens');
        Schema::dropIfExists('blacklisted_refresh_tokens');
    }
};
