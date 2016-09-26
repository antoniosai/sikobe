<?php

if (! function_exists('option')) {
    /**
     * Get a option.
     *
     * @param  string  $handle
     * 
     * @return string
     * @throws \App\Modules\Option\RecordNotFoundException
     */
    function option($handle)
    {
        return \Option::get($handle);
    }
}

if (! function_exists('setOption')) {
    /**
     * Set a option.
     *
     * @param  string  $handle
     * @param  string  $value
     * 
     * @return void
     */
    function setOption($handle, $value)
    {
        return \Option::set($handle, $value);
    }
}

if (! function_exists('fileUploadMaxSize')) {
    function fileUploadMaxSize() {
        static $maxSize = -1;

        if ($maxSize < 0) {
            // Start with post_max_size.
            $maxSize = parseIniSize(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $uploadMax = parseIniSize(ini_get('upload_max_filesize'));
            if ($uploadMax > 0 && $uploadMax < $maxSize) {
                $maxSize = $uploadMax;
            }
        }

        return $maxSize;
    }
}

if (! function_exists('parseIniSize')) {
    function parseIniSize($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        return round($size);
    }
}

if (! function_exists('humanFilesize')) {
    function humanFilesize($bytes, $decimals = 2) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}
