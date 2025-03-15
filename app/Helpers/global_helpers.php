<?php

if (!function_exists('mask_email')) {
    /**
     * Mask an email address, revealing only the domain and first letter.
     *
     * @param string $email
     * @return string
     */
    function mask_email(string $email): string
    {
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return $email; // Invalid email format
        }

        $name = $parts[0];
        $domain = $parts[1];

        // Show only the first letter and mask the rest with asterisks
        $maskedName = substr($name, 0, 1) . str_repeat('*', max(strlen($name) - 1, 0));

        return $maskedName . '@' . $domain;
    }
}

if (!function_exists('mask_phone')) {
    /**
     * Mask a phone number, revealing only the last 4 digits.
     *
     * @param string $phone
     * @return string
     */
    function mask_phone(string $phone): string
    {
        // Keep only numbers and remove any special characters
        $cleanPhone = preg_replace('/\D/', '', $phone);

        // Mask all but the last 4 digits
        return str_repeat('*', max(strlen($cleanPhone) - 4, 0)) . substr($cleanPhone, -4);
    }
}

if (!function_exists('getServerLimitInKB')) {
    /**
     * Retrieve a server's PHP configuration value (like upload_max_filesize, post_max_size,memory_limit)
     * and convert it to kilobytes (KB).
     *
     * @param string $key The name of the PHP INI configuration value (e.g., 'upload_max_filesize', 'post_max_size').
     * @return int|null The converted value in KB, or null if the configuration does not exist.
     */
    function getServerLimitInKB(string $key ='upload_max_filesize'): ?int
    {
        // Retrieve the PHP configuration value
        $value = ini_get($key);

        // If the value does not exist, return null
        if (!$value) return null;

        // Extract the unit (last character) and convert to lowercase
        $unit = strtolower(substr($value, -1));

        // Convert the numeric part of the value to an integer
        $value = (int) $value;

        // Convert the value based on its unit (K, M, G)
        switch ($unit) {
            case 'g': // If the unit is GB, convert to MB
                $value *= 1024;
            case 'm': // If the unit is MB, convert to KB
                $value *= 1024;
            case 'k': // If the unit is already in KB, return as is
                return $value;
            default:  // If the value is in bytes, convert to KB (1 KB = 1024 bytes)
                return round($value / 1024);
        }
    }
}


if (!function_exists('format_code')) {
    /**
     * Format a given code by adding spaces every N characters.
     *
     * @param string $code The input code to be formatted.
     * @param int $chunkSize The number of characters between spaces (default is 4).
     * @return string The formatted code with spaces.
     *
     * Example Usage:
     * format_code('WTR3AOWNUKYBXZLG');  // Output: "WTR3 AOWN UKYB XZLG"
     * format_code('ABCDEFGH', 3);       // Output: "ABC DEF GH"
     */
    function format_code(string $code, int $chunkSize = 4): string
    {
        // Ensure the chunk size is at least 1 to avoid division errors
        $chunkSize = max(1, $chunkSize);

        // Use str_split to break the string into smaller chunks
        $chunks = str_split($code, $chunkSize);

        // Join the chunks with spaces and return the formatted string
        return implode(' ', $chunks);
    }
}

if (!function_exists('getUserLocation')) {
    /**
     * Get user's location based on IP address using torann/geoip.
     *
     * @param string|null $ip
     * @return string
     */
    function getUserLocation($ip = null)
    {
        if (!$ip) return 'Unknown';

        try {
            $geo = \geoip()->getLocation($ip);
            $location = $geo['city'] . ', ' . $geo['country'];
        } catch (\Exception $e) {
            $location = "Unknown Location";
        }

        return $location;
    }
}

if (!function_exists('getUserDeviceType')) {
    /**
     * Get user's device type from user agent string using jenssegers/agent.
     *
     * @param string|null $userAgent
     * @return string
     */
    function getUserDeviceType($userAgent = null)
    {
        if (!$userAgent) return 'Unknown Device Type';

        $agent = new Jenssegers\Agent\Agent();

        $agent->setUserAgent($userAgent);


        return ucfirst($agent->deviceType());
    }
}
if (!function_exists('getUserDevice')) {
    /**
     * Get user's device from user agent string using jenssegers/agent.
     *
     * @param string|null $userAgent
     * @return string
     */
    function getUserDevice($userAgent = null)
    {
        if (!$userAgent) return 'Unknown Device';

        $agent = new Jenssegers\Agent\Agent();

        $agent->setUserAgent($userAgent);

        if ($agent->isDesktop()) {
            return 'Desktop';
        }elseif ($agent->isMobile()) {
            return 'Mobile';
        }elseif ($agent->isTablet()) {
            return 'Tablet';
        }
        else{
            return 'Unknown';
        }
    }
}
if (!function_exists('getUserPlatform')) {
    /**
     * Get user's platform from user agent string using jenssegers/agent.
     *
     * @param string|null $userAgent
     * @return string
     */
    function getUserPlatform($userAgent = null)
    {
        if (!$userAgent) return 'Unknown Platform';

        $agent = new Jenssegers\Agent\Agent();

        $agent->setUserAgent($userAgent);


        return ucfirst($agent->platform());
    }
}
if (!function_exists('getUserBrowser')) {
    /**
     * Get user's browser type from user agent string using jenssegers/agent.
     *
     * @param string|null $userAgent
     * @return string
     */
    function getUserBrowser($userAgent = null)
    {
        if (!$userAgent) return 'Unknown Browser';

        $agent = new Jenssegers\Agent\Agent();

        $agent->setUserAgent($userAgent);

        return $agent->browser();
    }
}
if (!function_exists('getCurrencySign')) {
    function getCurrencySign($currency = null)
    {
        // If no currency is passed, use the one from General Settings
        if (!$currency) {
            $currency = \App\Models\GeneralSetting::first()?->currency ?? 'NGN';
        }

        // Find currency symbol from Country model
        return \App\Models\Country::where('currency', $currency)->first()?->currency_symbol ?? '₦';
    }
}
