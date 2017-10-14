<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\userRole::class, 5)->create()->each(function ($u) {
        	factory(App\Model\User::class)->create();
    	});
    }
}
