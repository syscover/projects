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
                $table->string('description_090');

                // horas estimadas para la finalización y consumidas
                $table->integer('estimated_hours_090')->unsigned();
                $table->integer('consumed_hours_090')->unsigned();

                $table->integer('init_date_090')->unsigned();
                $table->string('init_date_text_090');

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
