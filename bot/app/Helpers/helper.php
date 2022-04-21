<?php

if (!function_exists('value')) {
    /**
     * [Larvel Helpers]
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

/**
 * [Larvel Helpers]
 * Determine if a given string starts with a given substring.
 *
 * @param  string  $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function startsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if ((string) $needle !== '' && str_starts_with($haystack, $needle)) {
            return true;
        }
    }

    return false;
}

/**
 * [Larvel Helpers]
 * Determine if a given string ends with a given substring.
 *
 * @param  string  $haystack
 * @param  string|string[]  $needles
 * @return bool
 */
function endsWith($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if (
            $needle !== '' && $needle !== null
            && str_ends_with($haystack, $needle)
        ) {
            return true;
        }
    }

    return false;
}

/**
 * [Larvel Helpers]
 * Gets the value of an environment variable. Supports boolean, empty and null.
 *
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return value($default);
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;

        case 'empty':
        case '(empty)':
            return '';

        case 'null':
        case '(null)':
            return;
    }

    if (startsWith($value, '"') && endsWith($value, '"')) {
        return substr($value, 1, -1);
    }

    return $value;
}

/**
 * @param string $value
 */
function config(string $value) {
    return Libraries\Config::get($value);
}

function getTelegramChatInstance(?int $user_id, ?string $name)
{
    try {
        if (!empty($user_id) && !empty($name)) {
            return sprintf("<a href=\"tg://user?id=%u\">%s</a>", $user_id, $name);
        } else {
            throw new \Exception("Error getting some value", 1);
            die;
        }
    } catch (\Exception $e) {
        throw new Exception($e->getMessage());
    }
}

/**
 * @return string
 */
function timeToNextDay(): string
{
    $date1 = new \DateTime('NOW');
    $date2 = new \DateTime();
    $date1 = $date1->format("Y-m-d H:i:s");
    $date2 = $date2->modify('+1 day')->format('Y-m-d 00:00:00');
    return strtotime($date2) - strtotime($date1);
}

/**
 * @param string $string
 * 
 * @return int
 */
function checkHtmlString(string $string): int
{
    $start_string = strpos($string, '<');
    $end_string = strrpos($string, '>', $start_string);
    if ($end_string !== false) {
        $string = substr($string, $start_string);
    } else {
        $string = substr($string, $start_string, strlen($string) - $start_string);
    }
    $string = "<div>$string</div>";
    libxml_use_internal_errors(true);
    libxml_clear_errors();
    simplexml_load_string($string);
    $ret = (count(libxml_get_errors()) == 0 ? true : false);
    return $ret;
}

function getParsedTimeLeft($time_left)
{
    return gmdate("H", $time_left) . ":" . gmdate("i", $time_left) . ":" . gmdate("s", $time_left);
}

/**
 * @param string $string
 * @param string $find_value
 * 
 * @return bool
 */
function contains(?string $string, ?string $find_value): bool
{
    if (!empty($string) && !empty($find_value)) {
        return (strpos($string, $find_value) !== false ? true : false);
    }
    return false;
}

/**
 * @return int
 */
function getUniqueId(): int
{
    return md5($_SERVER['REQUEST_TIME'] + mt_rand(1000, 9999));
}

/**
 * @param mixed $size
 * 
 * @return string
 */
function convert($size): string
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * @param int $strength
 * 
 * @return string
 */
function generateString(int $strength = 6): string
{
    $permitted = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $input_length = strlen($permitted);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $permitted[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

/**
 * @param int $user_id
 * 
 * @return string
 */
function createReferralId(int $user_id): string
{
    $user_id = (int) strrev($user_id);
    $user_id_lenght = strlen($user_id);
    $result = substr($user_id, 0, round($user_id_lenght / 2)) . 
        substr($user_id, round($user_id_lenght / 2), $user_id_lenght);
    return "ref0" . $result;
}

/**
 * @param int $user_id
 * 
 * @return string
 */
function createReferralUrl(int $user_id): string
{
    $ref_id = createReferralId($user_id);
    return sprintf('https://t.me/%s?start=%s', config('app.bot_name'), $ref_id);
}

/**
 * @param string $referral_id
 * 
 * @return int
 */
function reverseReferralId(string $referral_id): int
{
    $referral_id = str_replace('ref0', '', $referral_id);
    $referral_id_lenght = strlen($referral_id);
    $referral_id = substr($referral_id, 0, round($referral_id_lenght / 2)) . 
        substr($referral_id, round($referral_id_lenght / 2), $referral_id_lenght);
    $result = strrev($referral_id);
    return $result;
}