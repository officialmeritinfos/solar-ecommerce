<?php

namespace App;

use App\Mail\LoginAttemptNotification;
use App\Mail\PasswordChangedNotification;
use App\Mail\TwoFactorDisabledNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use Torann\GeoIP\Facades\GeoIP;

trait UserTrait
{
    /**
     * Determine the dashboard to redirect the user to based on their role.
     *
     * @return string
     */
    public function getDashboardUrl(): string
    {
        if ($this->is_admin||$this->is_staff) {
            return route('admin.dashboard');
        }

        if ($this->is_affiliate) {
            return route('affiliate.dashboard');
        }

        return route('user.dashboard'); // Default dashboard
    }

    /**
     * Send a login attempt notification email with IP, location, and device info.
     */
    public function sendLoginNotification(Request $request)
    {
        $ipAddress = $request->ip();
        $agent = new Agent();

        // Fetch location details (fails gracefully if IP is local)
        try {
            $geo = \geoip()->getLocation($ipAddress);
            $location = $geo['city'] . ', ' . $geo['country'];
        } catch (\Exception $e) {
            $location = "Unknown Location";
        }

        // Get device and browser details
        $device = $agent->device() . ' - ' . $agent->platform() . ' (' . $agent->browser() . ')';

        // Send the login attempt notification email
        Mail::to($this->email)->send(new LoginAttemptNotification($this, $ipAddress, $location, $device));
    }

    /**
     * Send a notification email when two-factor authentication is disabled.
     */
    public function sendTwoFactorDisabledNotification(Request $request)
    {
        $ipAddress = $request->ip();
        $agent = new Agent();

        // Fetch location details (fails gracefully if IP is local)
        try {
            $geo = \geoip()->getLocation($ipAddress);
            $location = $geo['city'] . ', ' . $geo['country'];
        } catch (\Exception $e) {
            $location = "Unknown Location";
        }

        // Get device and browser details
        $device = $agent->device() . ' - ' . $agent->platform() . ' (' . $agent->browser() . ')';
        $dateTime = now()->format('F j, Y, g:i A');

        Mail::to($this->email)->send(new TwoFactorDisabledNotification($this, $ipAddress, $location, $device, $dateTime));
    }

    /**
     * Send a notification email when a user's password is changed.
     */
    public function sendPasswordChangedNotification(Request $request)
    {
        $ipAddress = $request->ip();
        $agent = new Agent();

        // Fetch location details (fails gracefully if IP is local)
        try {
            $geo = \geoip()->getLocation($ipAddress);
            $location = $geo['city'] . ', ' . $geo['country'];
        } catch (\Exception $e) {
            $location = "Unknown Location";
        }

        // Get device and browser details
        $device = $agent->device() . ' - ' . $agent->platform() . ' (' . $agent->browser() . ')';
        $dateTime = now()->format('F j, Y, g:i A');

        Mail::to($this->email)->send(new PasswordChangedNotification($this, $ipAddress, $location, $device, $dateTime));
    }
}
