<?php

namespace App\Http\Controllers;

use App\Models\WatchParty;
use App\Services\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WatchPartyController extends Controller
{

    public function joinWatchParty(Request $request, $watch_party_code)
    {
        if (!$request->has('data')) {
            return abort(404, 'Missing data');
        }
        try {
            $decryptedData = Crypt::decrypt($request->query('data'));
            if (
                !isset($decryptedData['role']) ||
                !isset($decryptedData['stream_code']) ||
                !isset($decryptedData['watch_party']) ||
                !isset($decryptedData['watch_party']['code'])
            ) {
                return abort(403, 'Invalid or tampered data');
            }

            // Extract necessary data
            $startDate = $decryptedData['watch_party']['start_date'];
            $startTime = $decryptedData['watch_party']['start_time'];
            $endDate = $decryptedData['watch_party']['end_date'];
            $endTime = $decryptedData['watch_party']['end_time'];

            // Convert to Carbon instances for comparison
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime)
                ->setTimezone(config('app.timezone'))
                ->toIso8601String();  // ISO 8601 format

            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime)
            ->setTimezone(config('app.timezone'));
            if (now()->greaterThanOrEqualTo($endDateTime)) {
                return redirect()->route('watch-party.ended');
            }

            $xyz = base64_encode(request()->ip());
            if (env('NO_IP_ADDRESS') === true) {
                $xyz = "MTU0LjE5Mi4xMzguMzY=";
            }
            $response = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint("/getprivateitemplayerdetail/{$decryptedData['stream_code']}?user_data={$xyz}"));

            if ($response->failed()) {
                return abort(500, 'Failed to retrieve stream details');
            }
            $data = $response->json();
            if (empty($data['app']['stream_details'])) {
                return abort(404, 'Stream not found');
            }
            WatchParty::updateOrCreate(
                ['code' => $decryptedData['watch_party']['code']],
                [
                    'app_code' => $decryptedData['watch_party']['app_code'] ?? null,
                    'stream_code' => $decryptedData['stream_code'],
                    'title' => $decryptedData['watch_party']['title'] ?? 'Untitled Party',
                    'start_date' => $decryptedData['watch_party']['start_date'],
                    'start_time' => $decryptedData['watch_party']['start_time'],
                    'end_date' => $decryptedData['watch_party']['end_date'],
                    'end_time' => $decryptedData['watch_party']['end_time'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $userRole = $decryptedData['role'];
            if ($userRole === 'host') {
                return view("watch_party.host", [
                    'stream' => $data,
                    'startDateTime' => $startDateTime,
                    'role' => $userRole,
                    'watch_party_code' => $decryptedData['watch_party']['code']
                ]);
            } else {
                
                Log::info('sss'.$decryptedData['watch_party']['code']);
                
                return view("watch_party.viewer", [
                    'stream' => $data,
                    'startDateTime' => $startDateTime,
                    'role' => $userRole,
                    'watch_party_code' => $decryptedData['watch_party']['code']
                ]);
            }
        } catch (\Exception $e) {
            return abort(403, $e->getMessage());
        }
    }

    public function create()
    {
        return view('watch_party.create');
    }
    public function store(Request $request)
    {
        $validated =   $request->validate([
            'start_date'   => 'required|date',
            'title'   => 'required|string',
            'start_time'   => 'required|date_format:H:i',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'end_time'     => 'required|date_format:H:i',
            'viewer_emails' => 'required|array',
            'viewer_emails.*' => 'email',
            'stream_code'  => 'required|array',
            'stream_code.*' => 'string',
            'host_email'   => 'required|email',
        ]);
        $data = [
            'title'    => $validated['title'],
            'start_date'    => $validated['start_date'],
            'start_time'    => $validated['start_time'],
            'end_date'      => $validated['end_date'],
            'end_time'      => $validated['end_time'],
            'stream_code'   => $validated['stream_code'],
            'host_email'    => $validated['host_email'],
            'viewer_emails' => $validated['viewer_emails'],
        ];
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->post(Api::endpoint('/watchparty/store'), $data);
        $responseJson = $response->json();
        if ($response->successful()) {
            $successMessage = $responseJson['message'];
            return back()->with('success', $successMessage);
        } else {
            $errorMessage = $responseJson['message'];
            return back()->with('error', $errorMessage);
        }
    }
}
