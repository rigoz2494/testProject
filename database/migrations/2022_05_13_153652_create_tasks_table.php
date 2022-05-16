<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->tinyText('title');

            $table->longText('description')->nullable();

            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('executor_id')->constrained('users');

            $table->foreignId(\App\Models\Organisation::class)->constrained('organisations');
            $table->foreignIdFor(\App\Models\TaskStatuses::class)->constrained('task_statuses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
