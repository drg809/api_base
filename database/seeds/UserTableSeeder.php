<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Models\User\User::class, 5)->create();

    	DB::table('users')->insert([
    		[
    			'name' => 'Example', 
    			'email' => 'drg809@gmail.es',
	        	'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm' // secre
	        ]
	    ]);
    }
}
