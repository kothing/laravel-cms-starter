<?php

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        if(setting('app_name')) {
            return setting('app_name');
        } else {
            return config('app.name');
        }
    }
}

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('user_registration')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function user_registration()
    {
        $user_registration = false;

        if (env('USER_REGISTRATION') === 'true') {
            $user_registration = true;
        }

        return $user_registration;
    }
}

/*
 *
 * label_case
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('label_case')) {
    /**
     * Prepare the Column Name for Labels.
     */
    function label_case($text)
    {
        $order = ['_', '-'];
        $replace = ' ';

        $new_text = trim(\Illuminate\Support\Str::title(str_replace('"', '', $text)));
        $new_text = trim(\Illuminate\Support\Str::title(str_replace($order, $replace, $text)));

        return preg_replace('!\s+!', ' ', $new_text);
    }
}

/*
 *
 * show_column_value
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('show_column_value')) {
    /**
     * Generates the function comment for the given function.
     *
     * @param  string  $valueObject  Model Object
     * @param  string  $column  Column Name
     * @param  string  $return_format  Return Type
     * @param  mixed  $valueObject  The value object.
     * @param  mixed  $column  The column.
     * @param  string  $return_format  The return format. Default is empty string.
     * @return string Raw/Formatted Column Value
     * @return mixed The column value or formatted value.
     */
    function show_column_value($valueObject, $column, $return_format = '')
    {
        $column_name = $column->Field;
        $column_type = $column->Type;

        $value = $valueObject->$column_name;

        if (! $value) {
            return $value;
        }

        if ($return_format === 'raw') {
            return $value;
        }

        if (($column_type === 'date') && $value !== '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LL');
        }
        if (($column_type === 'datetime' || $column_type === 'timestamp') && $value !== '') {
            $datetime = \Carbon\Carbon::parse($value);

            return $datetime->isoFormat('LLLL');
        }
        if ($column_type === 'json') {
            $return_text = json_encode($value);
        } elseif ($column_type !== 'json' && \Illuminate\Support\Str::endsWith(strtolower($value), ['png', 'jpg', 'jpeg', 'gif', 'svg'])) {
            $img_path = asset($value);

            $return_text = '<figure class="figure">
                                <a href="'.$img_path.'" data-lightbox="image-set" data-title="Path: '.$value.'">
                                    <img src="'.$img_path.'" style="max-width:200px;" class="figure-img img-fluid rounded img-thumbnail" alt="">
                                </a>
                                <figcaption class="figure-caption">Path: '.$value.'</figcaption>
                            </figure>';
        } else {
            $return_text = $value;
        }

        return $return_text;
    }
}

/*
 *
 * fielf_required
 * Show a * if field is required
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('fielf_required')) {
    /**
     * Prepare the Column Name for Labels.
     */
    function fielf_required($required)
    {
        $return_text = '';

        if ($required !== '') {
            $return_text = '<span class="text-danger">*</span>';
        }

        return $return_text;
    }
}

/**
 * Get or Set the Settings Values.
 */
if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new App\Models\Setting();
        }

        if (is_array($key)) {
            return App\Models\Setting::set($key[0], $key[1]);
        }

        $value = App\Models\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}

/*
 * Show Human readable file size
 */
if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $step = 1024;
        $i = 0;

        while ($size / $step > 0.9) {
            $size /= $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}

/*
 *
 * Encode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('encode_id')) {
    /**
     * Prepare the Column Name for Labels.
     */
    function encode_id($id)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');

        return $hashids->encode($id);
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('decode_id')) {
    /**
     * Prepare the Column Name for Labels.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids\Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids->decode($hashid);

        if (count($id)) {
            return $id[0];
        }
        abort(404);
    }
}

/*
 *
 * Prepare a Slug for a given string
 * Laravel default str_slug does not work for Unicode
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('slug_format')) {
    /**
     * Format a string to Slug.
     */
    function slug_format($string)
    {
        $base_string = $string;

        $string = preg_replace('/\s+/u', '-', trim($string));
        $string = str_replace('/', '-', $string);
        $string = str_replace('\\', '-', $string);
        $string = strtolower($string);

        return substr($string, 0, 190);
    }
}

/*
 *
 * icon
 * A short and easy way to show icon fornts
 * Default value will be check icon from FontAwesome (https://fontawesome.com)
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('icon')) {
    /**
     * Format a string to Slug.
     */
    function icon($string = 'fa-regular fa-circle-check')
    {
        return "<i class='".$string."'></i>&nbsp;";
    }
}

/*
 *
 * logUserAccess
 * Get current user's `name` and `id` and
 * log as debug data. Additional text can be added too.
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('logUserAccess')) {
    /**
     * Format a string to Slug.
     */
    function logUserAccess($text = '')
    {
        $auth_text = '';

        if (\Auth::check()) {
            $auth_text = 'User:'.\Auth::user()->name.' (ID:'.\Auth::user()->id.')';
        }

        \Log::debug(label_case($text)." | {$auth_text}");
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('generate_rgb_code')) {
    /**
     * Prepare the Column Name for Labels.
     */
    function generate_rgb_code($opacity = '0.9')
    {
        $str = '';
        for ($i = 1; $i <= 3; $i++) {
            $num = mt_rand(0, 255);
            $str .= "{$num},";
        }
        $str .= "{$opacity},";

        return substr($str, 0, -1);
    }
}

/*
 *
 * Return Date with weekday
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('date_today')) {
    /**
     * Return Date with weekday.
     *
     * Carbon Locale will be considered here
     * Example:
     * Friday, July 24, 2020
     */
    function date_today()
    {
        return \Carbon\Carbon::now()->isoFormat('dddd, LL');
    }
}

if (! function_exists('language_direction')) {
    /**
     * return direction of languages.
     *
     * @return string
     */
    function language_direction($language = null)
    {
        if (empty($language)) {
            $language = app()->getLocale();
        }
        $language = strtolower(substr($language, 0, 2));
        $rtlLanguages = [
            'ar', //  'العربية', Arabic
            'arc', //  'ܐܪܡܝܐ', Aramaic
            'bcc', //  'بلوچی مکرانی', Southern Balochi
            'bqi', //  'بختياري', Bakthiari
            'ckb', //  'Soranî / کوردی', Sorani Kurdish
            'dv', //  'ދިވެހިބަސް', Dhivehi
            'fa', //  'فارسی', Persian
            'glk', //  'گیلکی', Gilaki
            'he', //  'עברית', Hebrew
            'lrc', //- 'لوری', Northern Luri
            'mzn', //  'مازِرونی', Mazanderani
            'pnb', //  'پنجابی', Western Punjabi
            'ps', //  'پښتو', Pashto
            'sd', //  'سنڌي', Sindhi
            'ug', //  'Uyghurche / ئۇيغۇرچە', Uyghur
            'ur', //  'اردو', Urdu
            'yi', //  'ייִדיש', Yiddish
        ];
        if (in_array($language, $rtlLanguages)) {
            return 'rtl';
        }

        return 'ltr';
    }
}

/*
 * Application Demo Mode check
 */
if (! function_exists('demo_mode')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function demo_mode()
    {
        $return_string = false;

        if (env('DEMO_MODE') === 'true') {
            $return_string = true;
        }

        return $return_string;
    }
}
