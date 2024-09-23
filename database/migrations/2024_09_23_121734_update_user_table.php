<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    public function up()
    {
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update([
                'name' => 'admin',
                'password' => bcrypt('merga@1234'),
                'role' => 'admin',
                'role_id' => 1,
                'updated_at' => now(),
            ]);
    }

    public function down()
    {
        DB::table('users')
            ->where('email', 'admin@gmail.com')
            ->update([
                'name' => null,
                'password' => null,
                'role' => null,
                'role_id' => null,
                'updated_at' => now(),
            ]);
    }
}
