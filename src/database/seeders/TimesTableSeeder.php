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
        for ($subDay = 2; $subDay >= 0; $subDay--){
            $this->add_db($subDay);
        }
    }


    private function add_db($subDay){
        $aryStartHr = array(8, 9, 10);
        $aryEndHr = array(17, 18, 19);
        for($user_id = 1; $user_id <= 20; $user_id++){
            $startKey = array_rand($aryStartHr, 1);
            $endKey = array_rand($aryEndHr, 1);
            $workStartDt = Carbon::now()->subDays($subDay)->setTime($aryStartHr[$startKey], 0, 0);
            $workEndDt = Carbon::now()->subDays($subDay)->setTime($aryEndHr[$endKey], 0, 0);
            $restStartDt = Carbon::now()->subDays($subDay)->setTime(12, 0, 0);
            $restEndDt = Carbon::now()->subDays($subDay)->setTime(13, 0, 0);
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
