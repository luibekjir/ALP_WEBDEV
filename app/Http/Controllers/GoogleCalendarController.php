<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{
    public function store(){
        
    }
    private function client()
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $client->addScope(Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    // 1️⃣ Redirect ke Google
    public function redirect()
    {
        $client = $this->client();
        return redirect()->away($client->createAuthUrl());
    }

    // 2️⃣ Callback dari Google
    public function callback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('event')->with('error', 'Google login dibatalkan');
        }

        $client = $this->client();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect()->route('event')->with('error', 'Gagal autentikasi Google');
        }

        $user = Auth::user();
        $user->google_token = json_encode($token);
        $user->save();

        return redirect()->route('event')->with('success', 'Google Calendar berhasil terhubung');
    }

    // 3️⃣ Tambahkan event ke Google Calendar
    public static function addEventToCalendar($event)
    {
        $user = Auth::user();

        if (!$user || !$user->google_token) {
            return false;
        }

        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));

        $token = json_decode($user->google_token, true);
        $client->setAccessToken($token);

        // Refresh token jika expired
        if ($client->isAccessTokenExpired() && isset($token['refresh_token'])) {
            $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
            $user->google_token = json_encode($client->getAccessToken());
            $user->save();
        }

        $service = new Calendar($client);

        $calendarEvent = new \Google\Service\Calendar\Event([
            'summary' => $event->title,
            'description' => $event->description,
            'start' => [
                'dateTime' => Carbon::parse($event->start)->toIso8601String(),
                'timeZone' => 'Asia/Jakarta',
            ],
            'end' => [
                'dateTime' => Carbon::parse($event->end)->toIso8601String(),
                'timeZone' => 'Asia/Jakarta',
            ],
        ]);

        $service->events->insert('primary', $calendarEvent);

        return true;
    }
}
