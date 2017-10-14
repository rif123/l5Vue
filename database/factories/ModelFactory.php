<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Model\User::class, function (Faker\Generator $faker) {
    static $password;
    $roles = App\Model\userRole::pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password',
        'username' => $faker->unique()->username,
        'jabatan' => $faker->jobTitle,
        'no_telp' => $faker->e164PhoneNumber,
        'role_id' => $faker->unique()->randomElement($array = $roles),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Model\userRole::class,function(Faker\Generator $faker) {
    $roles = ['developer','super','admin','front','room'];
	return [
		'role_name' => $faker->unique()->randomElement($array = $roles),
		'keterangan' => $faker->text($maxNbChars = 30) 
	];
});

$factory->define(App\Model\Kamar::class,function(Faker\Generator $faker){
    $roles = App\Model\kamarType::pluck('id')->toArray();
    return [
        'nomor_kamar' => $faker->unique()->randomNumber($nbDigits = 2),
        'type_id' => $faker->randomElement($array = $roles),
        'max_dewasa' => $faker->numberBetween($min = 1, $max = 5),
        'max_anak' => $faker->numberBetween($min = 1, $max = 5),
        'status' => 0
    ];
});

$factory->define(App\Model\kamarType::class,function(Faker\Generator $faker){
    return [
        'nama' => $faker->unique()->city,
        'harga_malam' => $faker->randomNumber($nbDigits = 6),
        'harga_orang' => $faker->randomNumber($nbDigits = 5),
        'keterangan' => $faker->text($maxNbChars = 200)  
    ];
});

$factory->define(App\Model\layananKategori::class,function(Faker\Generator $faker){
    return [
        'nama_layanan_kategori' => $faker->unique()->word,
        'keterangan' => $faker->text($maxNbChars = 200)
    ];
});

$factory->define(App\Model\Layanan::class,function(Faker\Generator $faker){
    $roles = App\Model\layananKategori::pluck('id')->toArray();
    return [
        'nama_layanan' => $faker->unique()->word,
        'layanan_kategori_id' => $faker->randomElement($array = $roles),
        'satuan' => $faker->tld,
        'harga' => $faker->randomNumber($nbDigits= 4)
    ];
});

$factory->define(App\Model\Tamu::class,function(Faker\Generator $faker){
    $type_iden = ['KTP','SIM','PASSPORT'];
    return [
        'prefix' => $faker->title,
        'nama_depan' => $faker->firstname,
        'nama_belakang' => $faker->lastname,
        'tipe_identitas' => $faker->randomElement($array = $type_iden),
        'nomor_identitas' => $faker->creditCardNumber,
        'warga_negara' => $faker->country,
        'alamat_jalan' => $faker->streetAddress,
        'alamat_kabupaten' => $faker->city,
        'alamat_provinsi' => $faker->state,
        'nomor_telp' => $faker->e164PhoneNumber,
        'email' => $faker->unique()->email
    ];
});

$factory->define(App\Model\Perusahaan::class,function(Faker\Generator $faker){
    return [
        'nama_hotel' => $faker->company,
        'nama_perusahaan' => $faker->company.' '.$faker->companySuffix,
        'alamat_jalan' => $faker->streetAddress,
        'alamat_kabupaten' => $faker->state,
        'alamat_provinsi' => $faker->state,
        'nomor_telp' => $faker->e164PhoneNumber,
        'nomor_fax' => $faker->e164PhoneNumber,
        'website' => $faker->domainName,
        'email' => $faker->email
    ];
});

$factory->define(App\Model\Berita::class,function(Faker\Generator $faker){
    $roles = App\Model\User::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($array = $roles),
        'isi_berita' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'title' => $faker->realText($maxNbChars = 30, $indexSize = 1),
        'status' => 1
    ];
});