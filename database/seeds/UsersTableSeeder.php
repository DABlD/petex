<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'fname' => 'Admin',
            'mname' => 'A',
            'lname' => 'Istrator',
            'role' => 'Admin',
            'email' => 'admin@admin.com',
            'birthday' => '1997-11-12',
            'gender' => 'Female',
            'address' => 'Manila',
            'lat' => 14.604119,
            'lng' => 120.9864307,
            'contact' => '09123456789',
            'email_verified_at' => now()->toDateTimeString(),
            'password' => '123456'
        ]);
    }
}
