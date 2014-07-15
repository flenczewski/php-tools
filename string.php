<?php


class String
{

    public static function truncate($string, $end) {
        if (strlen($string) > $end) {
            $string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $end+1)); 
            $string = substr($string, 0, $end) ."...";
        }

        return $string;
    }
    
    
    /**
     * Automagicznie adresy URL w tekście stają się klikalne
     * 
     * @param string $text
     * @return string
     */
    public static function clickable($text) {
        $ret = ' ' . $text;
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $ret);
        $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
        $ret = substr($ret, 1);

        return $ret;
    }

    /**
     * Jeżeli adres URL jest dłuższy niż $maxLength - zamienia jego srodek na $mask
     * - tak aby łączna długość nie przekraczała $maxLength - strlen($mask)
     * 
     * @param string $url		- adres strony
     * @param int $max_length	- długość
     * @param string $mask		- maska
     * @return string
     */
    function getShortViewUrl( $url, $maxLength = 45, $mask = '[ ... ]' ) {
        $length    = strlen($url);
        $maxLength = intval($maxLength);

        if($length > $maxLength) {
            $length = $length - ceil($maxLength/3*2);
            $first  = substr($url, 0, -$length);
            $last   = substr($url, -ceil($length/2));
            return $first . $mask . $last;
        } else {
            return $url;
        }
    }


    /**
     * Zwraca sformatowaną wielkosc pliku
     * 
     * @return string
     */
    public static function viewFileSize($size, $precision=2, $longName=true, $realSize=true) {
        $pos  = 0;
        $base = $realSize ? 1024 : 1000;

        while($size > $base) {
            $size/=$base;
            $pos++;
        }

        $prefix = array(" ",
                        "kilo",
                        "mega",
                        "giga",
                        "tera",
                        "peta",
                        "exa",
                        "zetta",
                        "yotta",
                        "xenna",
                        "w-",
                        "vendeka",
                        "u-",
                        "?-");

        $sizeName = $longName ? $prefix[$pos] .'byte' : $prefix[$pos][0] .'B';
        return round($size, $precision) .' '. ucfirst($sizeName);
    }
}
