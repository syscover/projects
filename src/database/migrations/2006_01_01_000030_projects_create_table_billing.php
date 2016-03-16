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
            Schema::create('006_092_billing', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_092')->unsigned();

                // tarea de donde procede este registro
                $table->integer('todo_id_092')->unsigned();

                // developer / usuario que se la ha asignado la tarea
                $table->integer('developer_id_092')->unsigned()->nullable();
                $table->integer('developer_name_092')->nullable();

                // cliente al que se le realiza la tarea
                $table->integer('customer_id_092')->unsigned()->nullable();
                $table->string('customer_name_092')->nullable();

                // descripción de la tarea
                $table->string('title_092');
                $table->text('description_092');

                // precio de la tarea, en el caso de haberse definido
                $table->decimal('price_092', 10, 2)->nullable();

                // fecha de petición de la tarea
                $table->integer('request_date_092')->unsigned();
                $table->string('request_date_text_092');

                // fechas de entrega
                $table->integer('end_date_092')->unsigned()->nullable();
                $table->string('end_date_text_092')->nullable();

                // número de horas realizadas en esta tarea
                $table->decimal('hours_092', 8, 2);

                // si está facturado o no
                $table->tinyInteger('invoiced_092')->unsigned();

                $table->foreign('developer_id_092', 'fk01_006_092_billing')->references('id_010')->on('001_010_user')
                    ->onDelete('set null')->onUpdate('cascade');
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
        if (Schema::hasTable('006_092_billing'))
        {
            Schema::drop('006_092_billing');
        }
    }
}