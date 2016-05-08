<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsCreateTableHistory extends Migration {

    /**
     * Table to record all invoiced quantity, to keep track on projects and hours worked
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('006_094_invoiced'))
        {
            Schema::create('006_094_history', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_094')->unsigned();

                // date of job invoiced
                $table->integer('date_094')->unsigned()->nullable();
                $table->string('date_text_094')->nullable();

                // Customer invoiced
                $table->integer('customer_id_094')->unsigned();
                $table->string('customer_name_094');
                
                // can to be: project o hour
                // 1 - project
                // 2 - hour
                $table->tinyInteger('type_094')->unsigned();
                
                // if is project, record your Project Id
                $table->integer('project_id_094')->unsigned()->nullable();

                // if is project, record your History Id
                $table->integer('history_id_094')->unsigned()->nullable();

                // precio de la tarea, en el cado de haberse definido
                $table->decimal('price_094', 10, 2)->nullable();
                
                $table->foreign('project_id_094', 'fk01_006_094_invoiced')->references('id_090')->on('006_090_project')
                    ->onDelete('set null')->onUpdate('cascade');
                $table->foreign('history_id_094', 'fk02_006_094_invoiced')->references('id_093')->on('006_093_history')
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
        if (Schema::hasTable('006_094_invoiced'))
        {
            Schema::drop('006_094_invoiced');
        }
    }
}