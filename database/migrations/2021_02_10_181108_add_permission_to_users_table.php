<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('permissions.table_name');
        $columnName = config('permissions.column_name');

        if (empty($tableName)) {
            throw new \Exception('Error: config/permissions.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if(!Schema::hasTable($tableName)) {
            throw new \Exception('Error: ' . $tableName . 'Does not exist. Create it and try again.');
        }

        Schema::table($tableName, function (Blueprint $table) use ($columnName) {
            $table->json($columnName)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableName = config('permission.table_name');

        if (empty($tableName)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropColumn($columnName);
        });
    }
}
