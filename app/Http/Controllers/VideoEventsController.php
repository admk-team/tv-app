<?php

namespace App\Http\Controllers;

use App\Models\VideoEvents;
use App\Models\WatchParty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VideoEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function getLatestPlayerState(Request $request)
    {
        $query = VideoEvents::orderBy('created_at', 'desc')
            ->where('instance_name', 'player1');

        if ($request->has('watch_party_code') && !empty($request->watch_party_code)) {
            $query->where('watch_party_code', $request->watch_party_code);
        }


        $latestEvent = $query->first();
        
        Log::info($request->watch_party_code);
    
        if (!$latestEvent) {
            return response()->json([
                'status' => 'no data',
                'message' => 'No player events found'
            ], 200);
        }

        // Clone the event data before deleting
        $response = $latestEvent->toArray();

        // Delete the event so it won't be returned next time
        $latestEvent->delete();

        return response()->json($response);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $watchPartyCode = $request->input('watch_party_code');

        $validated = $request->validate([
            'event_type' => 'required|string',
            'instance_name' => 'required|string',
            'media_data.current_time' => 'nullable|numeric',
            'media_data.duration' => 'nullable|numeric',
            'media_data.counter' => 'nullable|integer',
            'media_data.current_volume' => 'nullable',
            'media_data.seek_value' => 'nullable',
            'media_info' => 'nullable|array', // Validate as array
        ]);

        $event = VideoEvents::updateOrCreate(
            [
                'instance_name' => $validated['instance_name'],
            ],
            [
                'watch_party_code' => $watchPartyCode,
                'event_type' => $validated['event_type'],
                'current_time' => $validated['media_data']['current_time'],
                'duration' => $validated['media_data']['duration'],
                'counter' => $validated['media_data']['counter'],
                'seek_value' => $validated['media_data']['seek_value'],
                'current_volume' => $validated['media_data']['current_volume'],
                'media_info' => json_encode($validated['media_info']),
            ]
        );

        return response()->json([
            'event_ended' => false,
            'status' => 'success',
            'event' => $event,
        ]);
    }

    public function checkExpireTime(Request $request)
    {
        $watchPartyCode = $request->input('watch_party_code');
        $watchParty = WatchParty::where('code', $watchPartyCode)->first();
        if (!$watchParty) {
            return response()->json(['error' => 'Watch party not found'], 404);
        }
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $watchParty->end_date . ' ' .  $watchParty->end_time)
            ->setTimezone(config('app.timezone'));
        $eventEnded = now()->greaterThanOrEqualTo($endDateTime);
        // return redirect()->route('watch-party.ended');

        return response()->json([
            'event_ended' => $eventEnded,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(VideoEvents $videoEvents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoEvents $videoEvents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoEvents $videoEvents)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoEvents $videoEvents)
    {
        //
    }
}
