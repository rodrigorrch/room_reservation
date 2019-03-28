<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Room;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        Carbon::macro('rangeHour', function ($startDate, $endDate) {
            return new \DatePeriod($startDate, new \DateInterval('PT1H'), $endDate);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function getData(Request $request)
    {
        $week_orig = $request->input('week');
        unset($week_orig[5]);
        unset($week_orig[6]);

        $week = array_map(function($item){
            return Carbon::parse(preg_replace("/\(.+?\)/", '', $item));
        }, $week_orig);

        $week_ini = clone $week[0]->setTime(6,0);
        $week_end = clone $week[4]->setTime(23,0);

        $room =  Room::where('user_id', Auth::user()->id)->whereBetween('date', [$week_ini, $week_end->addDay()])->get();

        $room_key = $room->keyBy(function ($item) {
            return $item->date->isoFormat('HH:mm YYYY-MM-DD');
        });

        $list_week = [];

        foreach ($week as $key => $item){
            $day_ini = clone $week[$key]->setTime(6,0);
            $day_end = clone $week[$key]->setTime(24,0);

            $range_date = collect(Carbon::rangeHour($day_ini, $day_end))->keyBy(function ($item) {;
                return $item->isoFormat('HH:mm YYYY-MM-DD');
            });

            $list_week = $range_date->union($list_week);
        }

        $list_date = $room_key->union($list_week)->sortKeys()->chunk(5);
        $html = view('includes.table')->with(['list_date' => $list_date])->render();

        return \Response::json(['html' => $html]);
    }

    /**
     * @param Request $request
     * @return \Exception|null
     */
    public function storeOrUpdate(Request $request){
        $data = $request->input('data');

        try{
            $room = Room::findOrNew($data['id'] ?? 0);
            $room->user_id = Auth::user()->id;
            $room->date = Carbon::parse($data['date']);
            $room->name = $data['name'];
            $room->description = $data['desc'];
            $room->save();

            if(!$room) return null;

            return $room;
        }catch (\Exception $e){
            \Log::info($e);
            return $e;
        }
    }

    /**
     * @param Request $request
     * @return \Exception
     */
    public function delete(Request $request){
        $data = $request->input('data');

        try{
            $room = Room::find($data['id'])->delete();
            if($room){
                return 'ok';
            }
            return 'fail';
        }catch (\Exception $e){
            \Log::info($e);
            return $e;
        }
    }
}
