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
        // Validate the request and decrypt the data
        if (!$request->has('data')) {
            return abort(404, 'Missing data');
        }

        try {
            $decryptedData = Crypt::decrypt($request->query('data'));

            // Validate decrypted data
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
            // $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime)
            //     ->setTimezone(config('app.timezone'));
            $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startDate . ' ' . $startTime)
                ->setTimezone(config('app.timezone'))
                ->toIso8601String();  // ISO 8601 format

            $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endDate . ' ' . $endTime)
                ->setTimezone(config('app.timezone'));  // Make sure endDateTime is in the correct timezone

            if (now()->greaterThanOrEqualTo($endDateTime)) {
                return redirect()->route('watch-party.ended');
            }

            $hasStarted = now()->greaterThanOrEqualTo($startDateTime);

            $xyz = base64_encode(request()->ip());
            if (env('NO_IP_ADDRESS') === true) { // For localhost
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

            $watchPartyRecord = WatchParty::updateOrCreate(
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
}