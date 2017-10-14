<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\Model\Perusahaan::class)->create();

        factory(App\Model\userRole::class, 5)->create()->each(function ($u) {
            factory(App\Model\User::class)->create();
        });

        factory(App\Model\layananKategori::class, 5)->create()->each(function ($u) {
            factory(App\Model\Layanan::class,2)->create();
        });

        factory(App\Model\kamarType::class, 3)->create()->each(function ($u) {
            factory(App\Model\Kamar::class,5)->create();
        });

        factory(App\Model\Tamu::class,5)->create();
        factory(App\Model\Berita::class,5)->create();
    }
}
