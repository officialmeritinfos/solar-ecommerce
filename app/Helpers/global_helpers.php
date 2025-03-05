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
