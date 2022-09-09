<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('countries')->insert([
            'country_name' => 'Afghanistan',
            'country_code' => 'AF',
            'postal_code_format' => '1352',
        ]);

        DB::table('state_province')->insert([
            'name' => 'Test State',
            'country_id' => 1,
        ]);

        DB::table('cities')->insert([
            'city_name' => 'Test City',
            'state_province_id' => 1,
        ]);

        DB::table('contact_status')->insert([
            'contact_title' => 'First Contact',
        ]);

        DB::table('contact_status')->insert([
            'contact_title' => 'Second Contact',
        ]);

        DB::table('contact_status')->insert([
            'contact_title' => 'Third Contact',
        ]);

        DB::table('plans')->insert([
            'title' => 'Basic',
            'price' => 0,
            'recipient_limit' => 3,
            'video_audio_limit' => 3,
            'photo_limit' => 50,
            'status' => 1,
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Admin',
            'role_slug' => 'admin',
            'description' => 'Description about admin access',
            'status' => 1,
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'User',
            'role_slug' => 'user',
            'description' => 'Description about user access',
            'status' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Kumar',
            'last_name' => 'Khatri',
            'email' => 'kumar@gmail.com',
            'password' => Hash::make('Aa12345678'),
            'country_code' => 'pk',
            'phone_number' => '0302 1234567',
            'address' => 'Test Address',
            'address_2' => 'Test Address',
            'profile_image' => '/public/media/image/default.png',
            'role_id' => 1,
            'plan_id' => 1,
            'country_id' => 1,
            'state_province_id' => 1,
            'city_id' => 1,
            'zip_postal_code' => '75000',
            'status' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Sahil',
            'last_name' => 'Khatri',
            'email' => 'sahil@gmail.com',
            'password' => Hash::make('Aa12345678'),
            'country_code' => 'pk',
            'phone_number' => '0302 1234567',
            'address' => 'Test Address',
            'address_2' => 'Test Address',
            'profile_image' => '/public/media/image/default.png',
            'role_id' => 2,
            'plan_id' => 1,
            'country_id' => 1,
            'state_province_id' => 1,
            'city_id' => 1,
            'zip_postal_code' => '75000',
            'status' => 1,
        ]);
    }
}
