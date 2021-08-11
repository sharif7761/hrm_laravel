<?php

use App\UserWorkspace;
use Illuminate\Database\Seeder;

class UserWorkspaceTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserWorkspace::create([
            'user_id' => '2',
            'workspace_id' => '1',
            'permission' => 'Owner'
        ]);
    }
}
