<?php
namespace App\Services;

use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class DateFormatService
{
    /**
     * change format date strtotime
     */
    public function dateFormatLanguage($date = null, $format)
    {
        $language = App::getLocale();

        // format time
        if($date){   
            if($format == 'd/m/Y H:i'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = date('Y-m-d H:i',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == 'd/m/Y'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = date('Y-m-d',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == 'd/m/Y H:i:s'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = date('Y-m-d H:i:s',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == 'H:i'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = date('H:i',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == 'H:i:s'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,$date);
                        break;
                    case 'en':
                        $dateFormat = date('H:i:s',$date);
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == 'd/m H:i'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format,strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = date('m-d H:i',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
            if($format == '%A %d/%m/%Y'){
                switch ($language){
                    case 'vi':
                        $dateFormat = strftime($format, strtotime($date));
                        break;
                    case 'en':
                        $dateFormat = strftime('%A %Y-%m-%d',strtotime($date));
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
        } else {
            if($format == 'd/m/Y'){
                switch ($language){
                    case 'vi':
                        $dateFormat = date($format);
                        break;
                    case 'en':
                        $dateFormat = date('Y-m-d');
                        break;
                    default:
                        break;
                }
                return $dateFormat;
            }
        }
        
    }
    /**
     * change time format timestamp
     */
    public function dateFormatInput($date, $format)
    {
        $language = App::getLocale();
        if($format == 'd/m/Y'){
            switch ($language){
                case 'vi':
                    $dateFormat = $date;
                    break;
                case 'en':
                    $dateFormat = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    break;
                default:
                    break;
            }
            return $dateFormat;
        }
        if($format == 'm/Y'){
            switch ($language){
                case 'vi':
                    $dateFormat = $date;
                    break;
                case 'en':
                    $dateFormat = Carbon::createFromFormat('m/Y', $date)->format('Y-m');
                    break;
                default:
                    break;
            }
            return $dateFormat;
        }
    }
}