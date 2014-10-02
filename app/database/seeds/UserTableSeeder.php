<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create(array(
			'email' => 'claire.kavanagh@fipra.com',
			'password' => Hash::make('iamclairekavanagh')
		));
	}
}