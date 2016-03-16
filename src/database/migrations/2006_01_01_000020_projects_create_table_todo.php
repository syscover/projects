<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsCreateTableTodo extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('006_091_todo'))
        {
            Schema::create('006_091_todo', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_091')->unsigned();

                // developer / usuario que se la ha asignado la tarea
                $table->integer('developer_id_091')->unsigned()->nullable();
                $table->string('developer_name_091')->nullable();

                // puede ser: project o hours
                // 1 - project
                // 2 - hours
                $table->tinyInteger('type_091')->unsigned();

                // projecto al que pertenece la tarea, en caso de pertenecer a un proyecto
                $table->integer('project_id_091')->unsigned()->nullable();

                // selecciona un cliente en caso de no pertenecer a un proyecto
                $table->integer('customer_id_091')->unsigned()->nullable();
                $table->string('customer_name_091')->nullable();

                // descripción de la tarea
                $table->string('title_091');
                $table->text('description_091')->nullable();

                // precio de la tarea, en el caso de haberse definido
                $table->decimal('price_091', 10, 2)->nullable();

                // fecha de petición de la tarea
                $table->integer('request_date_091')->unsigned()->nullable();
                $table->string('request_date_text_091')->nullable();

                // fecha de petición de finalización de tarea
                $table->integer('end_date_091')->unsigned()->nullable();
                $table->string('end_date_text_091')->nullable();

                // número de horas realizadas en esta tarea
                $table->decimal('hours_091', 10, 2)->nullable();

                // si está facturado o no
                $table->boolean('invoiced_091')->default(false)->unsigned();

                $table->foreign('developer_id_091', 'fk01_006_091_todo')->references('id_010')->on('001_010_user')
                    ->onDelete('set null')->onUpdate('cascade');
                $table->foreign('project_id_091', 'fk02_006_091_todo')->references('id_090')->on('006_090_project')
                    ->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('006_091_todo'))
        {
            Schema::drop('006_091_todo');
        }
    }
}