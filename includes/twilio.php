<?php
// SMS feature is paused. This stub prevents accidental sending while originals are archived in /maintenance.

if (!defined('TWILIO_HELPER_INCLUDED')) {
    define('TWILIO_HELPER_INCLUDED', true);

    function get_twilio_client()
    {
        return null;
    }

    function twilio_normalize_phone($number)
    {
        if (empty($number)) return '';
        $clean = preg_replace('/[^+0-9]/', '', $number);
        if (strpos($clean, '00') === 0) {
            $clean = '+' . substr($clean, 2);
        }
        return $clean;
    }

    function twilio_send_sms($to, $message, &$error = null)
    {
        $error = 'SMS feature is paused.';
        error_log('[twilio stub] Attempted send to ' . $to);
        return false;
    }

    function twilio_send_and_log($conn, $to, $message, $sent_by = null)
    {
        $error = 'SMS feature is paused.';
        return [false, $error];
    }
}
