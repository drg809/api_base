<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

trait MyMigrations
{
	public static function myTimestamps($table)
	{
		$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		$table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
	}

	public static function myCreatedAt($table)
	{
		$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
	}
}