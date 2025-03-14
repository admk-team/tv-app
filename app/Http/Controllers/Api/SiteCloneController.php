<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreateSubdomainRequest;

class SiteCloneController extends Controller
{

    public function createSubdomain(CreateSubdomainRequest $request)
    {
        $input = $request->validated();
        $referer = request()->ip();

        // $input['name'] = Str::lower($input['name']);
        // $input['name'] = Str::replace(' ', '', $input['name']);
        // $input['name'] = Str::substr($input['name'], 0, 7);
        Log::info("Started");
        if ($referer === '46.202.176.117') {
            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://147.93.114.167:8090/api/createWebsite', [
                "adminUser" => "admin",
                "adminPass" => "2MQVOWTfUdFJLTJw",
                "domainName" => $input['subdomain'] . '.octv.online',
                "ownerEmail" => "abdul.haseeb.ali@gmail.com",
                "packageName" => "Default",
                "websiteOwner" => "admin",
                "ownerPassword" => "2MQVOWTfUdFJLTJw"
            ]);
            // Get response data
            $createdWebsite = $response->json(); // Decodes JSON response into an associative array
            // Define script path
            Log::info("Site Created");
            $scriptPath = base_path('finalscript.sh');

            // Define arguments
            $arg1 = escapeshellarg("/home/{$input['subdomain']}.octv.online/public_html");
            $arg2 = escapeshellarg($input['app_code']);
            $arg3 = escapeshellarg("{$input['subdomain']}.octv.online");

            // Run script with arguments
            $command = "echo 'iltbtlmn3520ashT@' | su - root -c 'sleep 120; /home/octv.online/public_html/finalscript.sh $arg1 $arg2 $arg3' 2>&1";
            $output = shell_exec($command);
            Log::info("Excuted Command");
            return response()->json([
                'success' => $referer,
                'script_output' => $output
            ]);
        }

        return response()->json(['error' => 'Try Again Later']);
    }
}
