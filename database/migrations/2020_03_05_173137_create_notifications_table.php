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
            $table->string('type')->nullable()->comment('消息类型：0-系统');
            $table->unsignedBigInteger('from_user_id')->default(0)->comment('发送方：0-系统');
            $table->unsignedBigInteger('to_user_id')->comment('接受方');
            $table->unsignedBigInteger('model_id')->default(0)->comment('关联模型 ID');
            $table->string('model_type')->nullable()->comment('关联模型类型');
            $table->text('data')->comment('消息内容');
            $table->timestamp('read_at')->nullable()->comment('是否已读');
            $table->timestamps();
            $table->softDeletes();
            $table->index('type');
            $table->index('from_user_id');
            $table->index('to_user_id');
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
