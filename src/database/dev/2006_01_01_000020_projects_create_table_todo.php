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

                // customer
                $table->integer('customer_id_091')->unsigned();
                $table->string('customer_name_091');

                // developer / usuario que se la ha asignado la tarea
                $table->integer('project_manager_id_091')->unsigned();

                // developer / usuario que se la ha asignado la tarea
                $table->integer('developer_id_091')->unsigned();
                $table->string('name_091');
                $table->text('description_091');

                // puede ser project o hours
                $table->tinyInteger('type_091')->unsigned();

                // project
                $table->integer('project_id_091')->unsigned();

                // número de horas realizadas en esta tarea
                $table->decimal('hours_091', 8, 2);

                // precio de la tarea, en el cado de haberse definido
                $table->decimal('price_091', 10, 2)->nullable();

                // fechas de petición de la tarea y fecha de entrega
                $table->integer('request_date_091')->unsigned();
                $table->string('request_date_text_091');
                $table->integer('end_date_091')->unsigned()->nullable();
                $table->string('end_date_text_091')->nullable();

                // si está facturado o no
                $table->tinyInteger('invoiced_091')->unsigned();
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
        Schema::drop('006_091_todo');
    }
}