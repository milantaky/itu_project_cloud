<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. USER
        Schema::create('User', function (Blueprint $table) {
            $table->bigIncrements('user_id'); // Použijeme standardní bigIncrements
            $table->string('user_firstname', 32);
            $table->string('user_lastname', 32);
            $table->string('user_email', 32);
            $table->string('user_password', 128);
            $table->binary('user_photo')->nullable();
            $table->timestamps();
        });

        // 2. AGROUP
        Schema::create('AGroup', function (Blueprint $table) {
            $table->bigIncrements('group_id');
            $table->string('group_name', 32);
            $table->string('group_label', 64)->nullable();
            $table->string('group_link', 128)->nullable();
            $table->binary('group_photo')->nullable();
            $table->timestamps();
        });

        // 3. GROUPUSER (Pivot)
        Schema::create('group_user', function (Blueprint $table) {
            $table->bigIncrements('id'); // Klasické jedno ID jako primární klíč
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Cizí klíče
            $table->foreign('group_id')->references('group_id')->on('AGroup')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('User')->onDelete('cascade')->onUpdate('cascade');

            // Unikátnost dvojice zajistíme tímto indexem namísto složeného primárního klíče
            $table->unique(['group_id', 'user_id']);
        });

        // 4. TRANSACTION
        Schema::create('Transaction', function (Blueprint $table) {
            $table->bigIncrements('t_id');
            $table->unsignedBigInteger('t_group_id');
            $table->unsignedBigInteger('t_user_payer_id');
            $table->unsignedBigInteger('t_user_debtor_id');
            $table->integer('t_amount');
            $table->string('t_currency', 10);
            $table->integer('t_exchange_rate');
            $table->string('t_label', 64)->nullable();
            $table->timestamps();

            $table->foreign('t_group_id')->references('group_id')->on('AGroup')->onUpdate('cascade');
            $table->foreign('t_user_payer_id')->references('user_id')->on('User')->onUpdate('cascade');
            $table->foreign('t_user_debtor_id')->references('user_id')->on('User')->onUpdate('cascade');
        });

        // 5. CHAT
        Schema::create('Chat', function (Blueprint $table) {
            $table->bigIncrements('message_id');
            $table->unsignedBigInteger('message_group_id');
            $table->unsignedBigInteger('message_user_id');
            $table->text('message_text');
            $table->timestamps();

            $table->foreign('message_group_id')->references('group_id')->on('AGroup')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('message_user_id')->references('user_id')->on('User')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Chat');
        Schema::dropIfExists('Transaction');
        Schema::dropIfExists('GroupUser');
        Schema::dropIfExists('AGroup');
        Schema::dropIfExists('User');
    }
};
