<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name'=>'aafridi',
            'email'=>'aafridi@gmial.com',
            'password'=>'aafridi',
            'phone'=>8128233456,
            'role'=>'1'

        ]);
        // php artisan db:seed --class=adminseeder -->run this q to insert value in data base.
         User::create([
            'name'=>'takshil',
            'email'=>'takshil@gmial.com',
            'password'=>'takshil',
            'phone'=>2131425363,
            'role'=>'1'

        ]);
    }
}
