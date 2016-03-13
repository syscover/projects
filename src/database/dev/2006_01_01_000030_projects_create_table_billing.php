<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsCreateTableBilling extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('006_092_billing'))
        {
            Schema::create('006_092_todo', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_092')->unsigned();

                // tarea de donde procede este registro
                $table->integer('todo_id_092')->unsigned();

                // customer
                $table->integer('customer_id_092')->unsigned();
                $table->string('customer_name_092');

                // developer / usuario que se la ha asignado la tarea
                $table->integer('developer_id_092')->unsigned();
                $table->string('name_092');
                $table->text('description_092');

                // número de horas realizadas en esta tarea
                $table->decimal('hours_092', 8, 2);

                // precio de la tarea, en el cado de haberse definido
                $table->decimal('price_092', 10, 2)->nullable();

                // fechas de petición de la tarea y fecha de entrega
                $table->integer('request_date_092')->unsigned();
                $table->string('request_date_text_092');
                $table->integer('end_date_092')->unsigned()->nullable();
                $table->string('end_date_text_092')->nullable();

                // si está facturado o no
                $table->tinyInteger('invoiced_092')->unsigned();
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
        Schema::drop('006_092_billing');
    }
}