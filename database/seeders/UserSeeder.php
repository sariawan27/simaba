<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => "Pengasuh",
            'email' => "pengasuh@mail.com",
            'password' => Hash::make('123'),
            'alamat' => "Sidanegara, Cilacap Tengah. Cilacap. Jawa Tengah",
            'no_identitas' => "33103019020",
            'no_telp' => "089483928190",
            'level' => "pengasuh",
        ]);

        //
    }
}
