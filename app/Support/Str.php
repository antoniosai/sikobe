<?php

namespace App\Support;

/*
 * Author: Sulaeman <me@sulaeman.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Str extends \Illuminate\Support\Str
{

    /**
     * Generate a random numeric string.
     *
     * @param    integer $length
     * @return integer
     */
    public static function randomNumeric($length = 16)
    {
        if ( ! $length or $length < 1 or $length > 100) {
            $length = 100;
        }

        $s = '';
        $i = 0;

        do {
            $s .= chr(mt_rand(48,57));
            $i++;
        } while ($i < $length);

        return $s;
    }

    /**
     * Return human readable file size.
     *
     * @param    
     * @return string
     */
    public static function humanReadableFileSize($size)
    {
        $filesizename = array(' Bytes', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
        return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
    }

}