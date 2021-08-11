<?php

use App\Workspace;
use Illuminate\Database\Seeder;

class WorkspaceTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workspace::create([
            'created_by'=> '2',
            'name'=> 'Company Workspace',
            'currency_code' => 'USD',
            'paypal_mode' => 'sandbox'
        ]);
    }
}
