<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsCreateTableProject extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('006_090_project'))
        {
            Schema::create('006_090_project', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_090')->unsigned();

                // datos del cliente
                $table->integer('customer_id_090')->unsigned();
                $table->string('customer_name_090');

                // descripción del proyecto
                $table->string('name_090');
                $table->text('description_090')->nullable();

                // horas estimadas para la finalización y consumidas
                $table->decimal('estimated_hours_090', 10, 2);
                $table->decimal('consumed_hours_090', 10, 2);
                $table->decimal('total_hours_090', 10, 2);

                // fecha de inicio del proyecto
                $table->integer('init_date_090')->unsigned()->nullable();
                $table->string('init_date_text_090')->nullable();

                // fecha de finalización estimada
                $table->integer('estimated_end_date_090')->unsigned()->nullable();
                $table->string('estimated_end_date_text_090')->nullable();

                // fecha de finalización real
                $table->integer('end_date_090')->unsigned()->nullable();
                $table->string('end_date_text_090')->nullable();
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
        Schema::drop('006_090_project');
    }
}
