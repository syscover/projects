<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsCreateTableHistory extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('006_093_history'))
        {
            Schema::create('006_093_history', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_093')->unsigned();

                // usuario que se la ha asignado la tarea
                $table->integer('user_id_093')->unsigned()->nullable();
                $table->string('user_name_093')->nullable();

                // puede ser: project o hours
                // 1 - project
                // 2 - hours
                $table->tinyInteger('type_id_093')->unsigned();

                // selecciona un cliente en caso de no pertenecer a un proyecto
                $table->integer('customer_id_093')->unsigned();
                $table->string('customer_name_093');

                // project al que pertenece la tarea, en caso de pertenecer a un proyecto
                $table->integer('project_id_093')->unsigned()->nullable();

                // descripción de la tarea
                $table->string('title_093');
                $table->text('description_093')->nullable();

                // fecha de petición de la tarea
                $table->integer('request_date_093')->unsigned()->nullable();
                $table->string('request_date_text_093')->nullable();

                // fecha de petición de finalización de tarea
                $table->integer('end_date_093')->unsigned()->nullable();
                $table->string('end_date_text_093')->nullable();

                // número de horas realizadas en esta tarea
                $table->decimal('hours_093', 8, 2)->nullable();

                // precio de la tarea, en el cado de haberse definido
                $table->decimal('price_093', 10, 2)->nullable();

                $table->foreign('user_id_093', 'fk01_006_093_history')
                    ->references('id_010')
                    ->on('001_010_user')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
                $table->foreign('project_id_093', 'fk02_006_093_history')
                    ->references('id_090')
                    ->on('006_090_project')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
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
        if (Schema::hasTable('006_093_history'))
        {
            Schema::drop('006_093_history');
        }
    }
}