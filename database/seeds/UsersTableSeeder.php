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
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234'),
            'type' => 'admin'
        ]);
        $adminUser = User::create([
            'name' => 'Company',
            'email' => 'company@gmail.com',
            'password' => Hash::make('1234'),
            'currant_workspace' => '1',
            'type' => 'company'
        ]);
    }
}
