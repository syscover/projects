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
        if(!Schema::hasTable('006_093_history'))
        {
            Schema::create('006_093_todo', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_093')->unsigned();

                // customer
                $table->integer('customer_id_093')->unsigned();
                $table->string('customer_name_093');

                // developer / usuario que se la ha asignado la tarea
                $table->integer('developer_id_093')->unsigned();
                $table->string('name_093');
                $table->text('description_093');

                // puede ser project o hours
                $table->tinyInteger('type_093')->unsigned();

                // project
                $table->integer('project_id_093')->unsigned();

                // número de horas realizadas en esta tarea
                $table->decimal('hours_093', 8, 2);

                // precio de la tarea, en el cado de haberse definido
                $table->decimal('price_093', 10, 2)->nullable();

                // fechas de petición de la tarea y fecha de entrega
                $table->integer('request_date_093')->unsigned();
                $table->string('request_date_text_093');
                $table->integer('end_date_093')->unsigned()->nullable();
                $table->string('end_date_text_093')->nullable();

                // si está facturado o no
                $table->boolean('invoiced_093')->default(false)->unsigned();
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
        Schema::drop('006_093_history');
    }
}