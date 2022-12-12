<?php

namespace App\Helpers;

class StringHelper
{

    /**
     * Convert string to phone number format
     *
     * @param $str
     * @return string|null
     */
    public function phoneNumberFormat($str) {
        if (strlen($str) == 10) {
            if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $str, $matches)) {
                return $matches[1] . ' ' . $matches[2] . ' ' . $matches[3];
            }
        } else if (strlen($str) == 11) {
            if (preg_match('/(\d{2})(\d{2})(\d{3})(\d{4})$/', $str, $matches)) {
                return '+' . $matches[1] . ' ' . $matches[2] . ' ' . $matches[3] . ' ' . $matches[4];
            }
        }
        return null;
    }

    /**
     * Format input string where like
     */
    public function formatStringWhereLike($string){
        return addcslashes($string,'%_\\');
    }

    /**
	* Escape html
    * @param string $str
    * @return string
	*/
	public static function escapeHtml($str) {
        $search = ['<', '>'];
        $replace = ['&lt;', '&gt'];
        return str_replace($search, $replace, $str);
	}
}