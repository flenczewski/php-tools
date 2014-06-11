class String
{

    public static function clickable($text)
    {
        $ret = ' ' . $text;
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $ret);
        $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
        $ret = substr($ret, 1);

        return $ret;
    }


    /**
     * Zwraca sformatowaną wielkosc pliku
     * 
     * @return string
     */
    public static function viewfileSize($size, $precision=2, $long_name=true, $real_size=true)
    {
        $pos  = 0;
        $base = $real_size ? 1024 : 1000;

        while ($size > $base) {
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

        $size_name = $long_name ? $prefix[$pos] .'byte' : $prefix[$pos][0] .'B';
        return round($size, $precision) .' '. ucfirst($size_name);
    }
}
