<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectsUpdateV1 extends Migration
{
	public function up()
	{
		if(!Schema::hasColumn('006_092_billing', 'request_date_092'))
		{
			Schema::table('006_092_billing', function (Blueprint $table) {
				$table->integer('request_date_092')->unsigned()->nullable()->after('description_092');
			});
		}

		if(!Schema::hasColumn('006_092_billing', 'request_date_text_092'))
		{
			Schema::table('006_092_billing', function (Blueprint $table) {
				$table->string('request_date_text_092')->nullable()->after('request_date_092');
			});
		}

		if(!Schema::hasColumn('006_090_project', 'end_date_090'))
		{
			Schema::table('006_090_project', function (Blueprint $table) {
				$table->integer('end_date_090')->unsigned()->nullable()->after('init_date_text_090');
			});
		}

		if(!Schema::hasColumn('006_090_project', 'end_date_text_090'))
		{
			Schema::table('006_090_project', function (Blueprint $table) {
				$table->string('end_date_text_090')->nullable()->after('end_date_090');
			});
		}
	}

	public function down(){}
}