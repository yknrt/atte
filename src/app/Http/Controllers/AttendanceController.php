<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AttendanceController extends Controller
{
    public function index()
    {
        // 現在ログインしているユーザーを取得
        $user = Auth::user();
        $date = Carbon::now()->format('Y-m-d');
        $query = Time::where('user_id', $user->id)->where('stamped_at', 'like', $date . '%')->latest()->first();
        return view('stamp', ['user' => $user, 'query' => $query]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request['user_id'] = $user->id;
        $request['stamped_at'] = Carbon::now()->toDateTimeString();
        Time::create(
            $request->only([
                'user_id',
                'attendance',
                'stamped_at'
            ])
        );
        $date = Carbon::now()->format('Y-m-d');
        $query = Time::where('user_id', $user->id)->where('stamped_at', 'like', $date . '%')->latest()->first();
        return view('stamp', ['user' => $user, 'query' => $query]);
    }

    public function attendance(Request $request)
    {
        $user = Auth::user();
        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
        }
        else {
            $date = Carbon::today();
        }
        if ($request->has('addDay')) {
            $date = $date->addDay();
        }elseif ($request->has('subDay')) {
            $date = $date->subDay();
        }
        $date = $date->format('Y-m-d');
        $times = Time::where('stamped_at', 'like', $date . '%')->get();
        $uid = array();
        $rows = array();
        foreach ($times as $time) {
            $uid[] = $time->user_id;
        }
        $uniUid = array_unique($uid);
        foreach ($uniUid as $uid) {
            $name = User::find($uid)->name;
            $row = array('name' => $name, 'workIn' => NULL, 'workOut' => NULL, 'workTime' => NULL, 'restTime' => NULL);
            $attendances = Time::where('stamped_at', 'like', $date . '%')->where('user_id', $uid)->get();
            //view用配列を作成する関数
            $row = $this->make_array_time($row, $attendances);
            $rows[] = $row;
        }
        $paginatedItems = $this->paginated_items($rows);
        return view('date', ['date' => $date, 'items' => $paginatedItems]);
    }

    public function attendanceUser()
    {
        $user = Auth::user();
        $uid = $user->id;
        $registers = User::all();
        $times = Time::where('user_id', $uid)->get();
        $dates = array();
        $rows = array();
        foreach ($times as $time) {
            $dates[] = Carbon::parse($time->stamped_at)->format('Y-m-d');
        }
        $uniDates = array_unique($dates);
        rsort($uniDates);
        foreach ($uniDates as $date) {
            $row = array('date' => $date, 'workIn' => NULL, 'workOut' => NULL, 'workTime' => NULL, 'restTime' => NULL);
            $attendances = Time::where('user_id', $uid)->where('stamped_at', 'like', $date . '%')->get();
            //view用配列を作成する関数
            $row = $this->make_array_time($row, $attendances);
            $rows[] = $row;
        }
        $paginatedItems = $this->paginated_items($rows);
        return view('user', ['uid' => $uid, 'registers' => $registers, 'items' => $paginatedItems]);
    }

    public function searchUser(Request $request)
    {
        $registers = User::all();
        $user = User::find($request->user_id);
        $uid = $user->id;
        $times = Time::where('user_id', $uid)->get();
        $dates = array();
        $rows = array();
        foreach ($times as $time) {
            $dates[] = Carbon::parse($time->stamped_at)->format('Y-m-d');
        }
        $uniDates = array_unique($dates);
        rsort($uniDates);
        foreach ($uniDates as $date) {
            // $row['date'] = $date;
            $row = array('date' => $date, 'workIn' => NULL, 'workOut' => NULL, 'workTime' => NULL, 'restTime' => NULL);
            $attendances = Time::where('user_id', $uid)->where('stamped_at', 'like', $date . '%')->get();
            //view用配列を作成する関数
            $row = $this->make_array_time($row, $attendances);
            $rows[] = $row;
        }
        $paginatedItems = $this->paginated_items($rows);
        return view('user', ['uid' => $uid, 'registers' => $registers, 'items' => $paginatedItems]);
    }


    //view用配列を作成する関数
    private function make_array_time($row, $attendances){
        // 初期化
        $restIns = array();
        $restOuts = array();
        foreach ($attendances as $attendance) {
            if ($attendance->attendance === 1) {
                $row['workIn'] = Carbon::parse($attendance->stamped_at)->format('H:i:s');
            }elseif ($attendance->attendance === 2) {
                $row['workOut'] = Carbon::parse($attendance->stamped_at)->format('H:i:s');
            }elseif ($attendance->attendance === 3) {
                $restIns[] = $attendance->stamped_at;
            }elseif ($attendance->attendance === 4) {
                $restOuts[] = $attendance->stamped_at;
            }
        }
        //勤務時間の計算
        if (empty($row['workOut'])) {
            $row['workOut'] = '--';
            $row['workTime'] = '--';
        }
        else {
            $difSeconds = $this->time_diff($row['workIn'], $row['workOut']);
            $workDeltaTime = $this->delta_time($difSeconds);
            $row['workTime'] = sprintf('%02d', $workDeltaTime['hours']) . ':' . sprintf('%02d', $workDeltaTime['minutes']) . ':' . sprintf('%02d', $workDeltaTime['seconds']);
        }
        //休憩時間の計算
        $difSeconds = 0;
        for ($i = 0 ; $i < count($restIns); $i++) {
            if (count($restOuts) > $i) {
                $difSeconds += $this->time_diff($restIns[$i], $restOuts[$i]);
            }
        }
        $restDeltaTime = $this->delta_time($difSeconds);
        $row['restTime'] = sprintf('%02d', $restDeltaTime['hours']) . ':' . sprintf('%02d', $restDeltaTime['minutes']) . ':' . sprintf('%02d', $restDeltaTime['seconds']);
        if (empty($row['restTime'])) {
            $row['restTime'] = '00:00:00';
        }
        return $row;
    }

    //秒差を返す関数
    private function time_diff($d1, $d2){
        //タイムスタンプ
        $timeStamp1 = strtotime($d1);
        $timeStamp2 = strtotime($d2);
        //タイムスタンプの差を計算
        $difSeconds = $timeStamp2 - $timeStamp1;
        //結果を返す
        return $difSeconds;
    }
    //秒差を時分秒差に変換する関数
    private function delta_time($difSeconds){
        //秒の差を取得
        $deltaTime['seconds'] = $difSeconds % 60;
        //分の差を取得
        $difMinutes = ($difSeconds - ($difSeconds % 60)) / 60;
        $deltaTime['minutes'] = $difMinutes % 60;
        //時の差を取得
        $difHours = ($difMinutes - ($difMinutes % 60)) / 60;
        $deltaTime['hours'] = $difHours;
        return $deltaTime;
    }

    //ページネーション関数
    private function paginated_items($data){
        // 配列をコレクションに変換
        $collection = collect($data);

        // ページ情報を取得
        $page = request()->get('page', 1); // 現在のページ (デフォルトは1)
        $perPage = 5; // 1ページあたりのアイテム数

        // forPageで特定のページのデータを抽出
        $items = $collection->forPage($page, $perPage);

        // LengthAwarePaginatorを使ってページネーションを作成
        $paginatedItems = new LengthAwarePaginator(
            $items, // 現在のページのアイテム
            $collection->count(), // 合計アイテム数
            $perPage, // 1ページあたりのアイテム数
            $page, // 現在のページ番号
            ['path' => request()->url()] // ページネーションリンクのURLを生成
        );
        return $paginatedItems;
    }

}

