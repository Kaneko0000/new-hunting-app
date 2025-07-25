<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HunterLog;
use App\Models\Hunter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HunterLogController extends Controller
{
    // HunterLogController.php
    public function index(Request $request)
    {
        $date = $request->query('date');

        if ($date) {
            $logs = HunterLog::where('hunter_id', auth()->id())
                ->whereDate('capture_date', $date)
                ->with('animal', 'weather', 'huntingMethod')
                ->get();
        } else {
            $logs = collect();
        }

        return view('hunters.logs.index', compact('logs', 'date'));
    }

    public function create()
    {
        $mapboxToken = config('services.mapbox.token');
        return view('hunters.log', compact('mapboxToken'));
    }

    public function edit(HunterLog $log)
    {
        // dd($log);
        $mapboxToken = config('services.mapbox.token');
        return view('hunters.log', compact('log', 'mapboxToken'));
    }
    
    public function destroy(HunterLog $log, Request $request) 
    {
        $date = $request->query('date') ?? $log->capture_date?->toDateString();
        $log->delete();

        return redirect()->route('hunters.logs.index', ['date'=> $date])
            ->with('success', '狩猟記録を削除しました。');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'capture_date' => 'required|date',
            'capture_time' => 'required',
            'location' => 'required|string|max:255',
            'animal_id' => 'required|integer',
            'count' => 'required|integer|min:1',
            'weather_id' => 'nullable|integer',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'comments' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hunting_method_id' => 'required|integer',
        ]);

        // 🆕 位置情報（住所文字列）から都道府県を抽出する処理を追加
        $fullAddress = $validatedData['location']; // 例: 熊本県天草市五和町...
        $prefecture = null;

        if (preg_match('/^(.{2,3}県|.{2,3}都|.{2,3}府|.{2,3}道)/u', $fullAddress, $matches)) {
            $prefecture = $matches[1]; // 熊本県など
        }
        
        $log = new HunterLog();
        $log->hunter_id = Auth::id();
        $log->capture_date = $validatedData['capture_date'];
        $log->capture_time = $validatedData['capture_time'];
        $log->animal_id = $validatedData['animal_id'];
        $log->count = $validatedData['count'];
        $log->weather_id = $validatedData['weather_id'] ?? null;
        $log->latitude = $validatedData['latitude'] ?? null;
        $log->longitude = $validatedData['longitude'] ?? null;
        $log->hunting_method_id = $validatedData['hunting_method_id'] ?? null;
        $log->comments = $validatedData['comments'] ?? null;
        
        $log->address = $fullAddress;     // 🆕 住所全体
        $log->prefecture = $prefecture;   // 🆕 都道府県だけ
        

        // 画像アップロード
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('hunter_logs', 'public');
            $log->photo = $path;
        }

        $log->save();
        Log::info('狩猟記録を保存: ', ['log' => $log]);

        return redirect()->route('hunters.dashboard')->with('success', '狩猟記録を保存しました！');
    }

    public function update(Request $request, HunterLog $log)
{
    $validatedData = $request->validate([
        'capture_date' => 'required|date',
        'capture_time' => 'required',
        'location' => 'required|string|max:255',
        'animal_id' => 'required|integer',
        'count' => 'required|integer|min:1',
        'weather_id' => 'nullable|integer',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'comments' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'hunting_method_id' => 'required|integer',
    ]);

    $fullAddress = $validatedData['location'];
    $prefecture = null;
    if (preg_match('/^(.{2,3}県|.{2,3}都|.{2,3}府|.{2,3}道)/u', $fullAddress, $matches)) {
        $prefecture = $matches[1];
    }

    $log->fill([
        'capture_date' => $validatedData['capture_date'],
        'capture_time' => $validatedData['capture_time'],
        'animal_id' => $validatedData['animal_id'],
        'count' => $validatedData['count'],
        'weather_id' => $validatedData['weather_id'] ?? null,
        'latitude' => $validatedData['latitude'] ?? null,
        'longitude' => $validatedData['longitude'] ?? null,
        'hunting_method_id' => $validatedData['hunting_method_id'],
        'comments' => $validatedData['comments'] ?? null,
        'address' => $fullAddress,
        'prefecture' => $prefecture,
    ]);

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('hunter_logs', 'public');
        $log->photo = $path;
    }

    $log->save();

    // return redirect()->route('hunters.logs.index', ['date' => $log->capture_date])
    return redirect()->route('hunters.logs.index', ['date' => $log->capture_date->toDateString()])
        ->with('success', '狩猟記録を更新しました。');
}

}
