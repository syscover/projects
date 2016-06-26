<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Syscover\Pulsar\Libraries\DBLibrary;

class ProjectsUpdateV5 extends Migration
{
	public function up()
	{
		// rename columns
		// type_091
		DBLibrary::renameColumn('006_091_todo', 'type_091', 'type_id_091', 'TINYINT', 3, true, false);

		// type_093
		DBLibrary::renameColumn('006_093_history', 'type_093', 'type_id_093', 'TINYINT', 3, true, false);

		// type_094
		DBLibrary::renameColumn('006_094_invoiced', 'type_094', 'type_id_094', 'TINYINT', 3, true, false);
	}

	public function down(){}
}