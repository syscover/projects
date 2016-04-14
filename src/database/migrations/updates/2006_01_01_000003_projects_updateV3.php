<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsUpdateV3 extends Migration
{
	public function up()
	{
		if(!Schema::hasColumn('006_090_project', 'price_090'))
		{
			Schema::table('006_090_project', function (Blueprint $table) {
				$table->decimal('price_090', 10, 2)->nullable()->after('total_hours_090');
			});
		}
	}

	public function down(){}
}