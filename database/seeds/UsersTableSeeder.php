<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')
		->insert([
					'name' => 'Matheus Alves de Andrade',
					'email' => 'matheuseejam@gmail.com',
					'password' => bcrypt('p4yt0ur')
				]
		);
    }
}
