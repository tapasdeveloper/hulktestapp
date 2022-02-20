<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
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
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('title', 250)->nullable(false);
            $table->text('description')->nullable(true);
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedTinyInteger('priority_level')->default(1)->comment('1:Low 2:Medium 3:High');
            $table->dateTime('dead_line')->nullable(false)->default(Carbon::now()->add(2, 'day')->isoFormat('YYYY-MM-DD'));
            $table->unsignedTinyInteger('status')->default(1)->comment('1:ToDo 2:Inprogress 3:Done');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
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
