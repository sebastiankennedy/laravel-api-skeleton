<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('消息通知 ID');
            $table->string('type')->comment('消息类型');
            $table->unsignedBigInteger('model_id')->comment('模型 ID');
            $table->string('model_type')->comment('模型类型');
            $table->text('data')->comment('消息内容');
            $table->timestamp('read_at')->nullable()->comment('是否已读');
            $table->timestamps();
            $table->index(['model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
