<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($user_id = 1; $user_id <= 5; $user_id++){
            $workStartDt = Carbon::now()->subDays(2)->setTime(8, 0, 0);
            $workEndDt = Carbon::now()->subDays(2)->setTime(17, 0, 0);
            $restStartDt = Carbon::now()->subDays(2)->setTime(12, 0, 0);
            $restEndDt = Carbon::now()->subDays(2)->setTime(13, 0, 0);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 1,
                'stamped_at' => $workStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 3,
                'stamped_at' => $restStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 4,
                'stamped_at' => $restEndDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 2,
                'stamped_at' => $workEndDt
            ]);
        }
        for($user_id = 6; $user_id <= 10; $user_id++){
            $workStartDt = Carbon::now()->subDays(2)->setTime(9, 0, 0);
            $workEndDt = Carbon::now()->subDays(2)->setTime(18, 0, 0);
            $restStartDt = Carbon::now()->subDays(2)->setTime(12, 0, 0);
            $restEndDt = Carbon::now()->subDays(2)->setTime(13, 0, 0);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 1,
                'stamped_at' => $workStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 3,
                'stamped_at' => $restStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 4,
                'stamped_at' => $restEndDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 2,
                'stamped_at' => $workEndDt
            ]);
        }
        for($user_id = 1; $user_id <= 10; $user_id++){
            $workStartDt = Carbon::now()->subDays(1)->setTime(10, 0, 0);
            $workEndDt = Carbon::now()->subDays(1)->setTime(19, 0, 0);
            $restStartDt = Carbon::now()->subDays(1)->setTime(13, 0, 0);
            $restEndDt = Carbon::now()->subDays(1)->setTime(14, 0, 0);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 1,
                'stamped_at' => $workStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 3,
                'stamped_at' => $restStartDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 4,
                'stamped_at' => $restEndDt
            ]);
            DB::table('times')->insert([
                'user_id' => $user_id,
                'attendance' => 2,
                'stamped_at' => $workEndDt
            ]);
        }
    }
}
