<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsUpdateV4 extends Migration
{
	public function up()
	{
		if(! Schema::hasColumn('006_090_project', 'invoiced_090'))
		{
			Schema::table('006_090_project', function (Blueprint $table) {
				$table->boolean('invoiced_090')->after('end_date_text_090');
			});
		}
	}

	public function down(){}
}