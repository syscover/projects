<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProjectsUpdateV2 extends Migration
{
	public function up()
	{
		if(Schema::hasColumn('006_091_todo', 'developer_id_091'))
		{
			$key = DB::select(DB::raw('SHOW KEYS FROM 006_091_todo WHERE Key_name=\'fk01_006_091_todo\''));

			if($key != null)
			{
				Schema::table('006_091_todo', function (Blueprint $table) {
					$table->dropForeign('fk01_006_091_todo');
					$table->dropIndex('fk01_006_091_todo');
				});

				Schema::table('006_091_todo', function (Blueprint $table) {

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_091_todo CHANGE developer_id_091 user_id_091 INT(10) UNSIGNED NULL'));

					$table->foreign('user_id_091', 'fk01_006_091_todo')->references('id_010')->on('001_010_user')
						->onDelete('set null')->onUpdate('cascade');

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_091_todo CHANGE developer_name_091 user_name_091 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL'));
				});
			}
		}

		if(Schema::hasColumn('006_092_billing', 'developer_id_092'))
		{
			$key = DB::select(DB::raw('SHOW KEYS FROM 006_092_billing WHERE Key_name=\'fk01_006_092_billing\''));

			if($key != null)
			{
				Schema::table('006_092_billing', function (Blueprint $table) {
					$table->dropForeign('fk01_006_092_billing');
					$table->dropIndex('fk01_006_092_billing');
				});

				Schema::table('006_092_billing', function (Blueprint $table) {

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_092_billing CHANGE developer_id_092 user_id_092 INT(10) UNSIGNED NULL'));

					$table->foreign('user_id_092', 'fk01_006_092_billing')->references('id_010')->on('001_010_user')
						->onDelete('set null')->onUpdate('cascade');

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_092_billing CHANGE developer_name_092 user_name_092 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL'));
				});
			}
		}

		if(Schema::hasColumn('006_093_history', 'developer_id_093'))
		{
			$key = DB::select(DB::raw('SHOW KEYS FROM 006_093_history WHERE Key_name=\'fk01_006_093_historical\''));

			if($key != null)
			{
				Schema::table('006_093_history', function (Blueprint $table) {
					$table->dropForeign('fk01_006_093_historical');
					$table->dropIndex('fk01_006_093_historical');
					$table->dropForeign('fk02_006_093_historical');
					$table->dropIndex('fk02_006_093_historical');
				});

				Schema::table('006_093_history', function (Blueprint $table) {

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_093_history CHANGE developer_id_093 user_id_093 INT(10) UNSIGNED NULL'));

					$table->foreign('user_id_093', 'fk01_006_093_history')->references('id_010')->on('001_010_user')
						->onDelete('set null')->onUpdate('cascade');
					$table->foreign('project_id_093', 'fk02_006_093_history')->references('id_090')->on('006_090_project')
						->onDelete('set null')->onUpdate('cascade');

					// rename column
					DB::select(DB::raw('ALTER TABLE 006_093_history CHANGE developer_name_093 user_name_093 VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL'));
				});
			}
		}
	}

	public function down(){}
}