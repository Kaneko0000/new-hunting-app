<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HunterLog;
use App\Models\Hunter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HunterLogController extends Controller
{
    public function create()
    {
        return view('hunters.log'); // `log.blade.php` を表示
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
        
        // 🛠 モデルへセット
        $log = new HunterLog();
        $log->hunter_id = Auth::id();
        $log->capture_date = $validatedData['capture_date'];
        $log->capture_time = $validatedData['capture_time'];
        $log->animal_id = $validatedData['animal_id'];
        $log->count = $validatedData['count'];
        $log->weather_id = $validatedData['weather_id'] ?? null;
        $log->latitude = $validatedData['latitude'] ?? null;
        $log->longitude = $validatedData['longitude'] ?? null;
        $log->comments = $validatedData['comments'] ?? null;
        $log->hunting_method_id = $validatedData['hunting_method_id'] ?? null;
        

        // 画像アップロード
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('hunter_logs', 'public');
            $log->photo = $path;
        }

        $log->save();
        Log::info('狩猟記録を保存: ', ['log' => $log]);

        return redirect()->route('hunters.dashboard')->with('success', '狩猟記録を保存しました！');
    }
}
