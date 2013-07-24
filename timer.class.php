<?
/**
 *  Timer - oblicza różnicę pomiędzy dowolnymi markerami czasu
 *  
 *  @author: Fabian Lenczewski <fabian.lenczewski # gmail.com>
 *  @since: 2009-03-25
 *  @version: 1.0 - 2009-03-27
 */

class timer
{
    /**
     * Konstruktor
     * 
     * @param bool $init - czy zacząć pomiar
     */
 
    function timer( $init = false )
    {
        isset($init) ? $this->start() : null;
    }
 
    /**
     * Rozpoczęcie pomiaru
     * 
     * @return void
     */
    function start()
    {
        $this->setMarker('start');
    }
     
    /**
     * Zakończenie pomiaru
     * 
     * @param bool $return - czy zwrócić czas wykonywania (start-stop)
     * @return float
     */
    function stop( $return = false )
    {
        // ustawiamy marker
        $this->setMarker('stop');
         
        //zwracamy wynik
        if( $return == true )
        {
            return $this->display();
        }
    }
 
     
    /**
     * Ustawianie markera
     * jeżeli nazwa jest już wykorzystana, ustawiana jest nowa na podstawie czasu
     * 
     * @param string $name - nazwa markera
     * @return void
     */
    function setMarker( $name )
    {
        if( isset( $this->$name ) ) 
        {
            $name = '_'. time();
        }
         
        $timeofday   = gettimeofday();
        $this->$name = ($timeofday['sec'] + ($timeofday['usec'] / 1000000));
    }
     
    /**
     * Wyświetla różnicę czasu w markerach
     * 
     * @param string $marker1 - nazwa pierwszego markera
     * @param string $marker2 - nazwa drugiego markera
     * @return float
     */
    function display( $marker1 = 'start', $marker2 = 'stop')
    {
        return number_format( ($this->$marker2) - ($this->$marker1), 5 );
    }
 
     
    /**
     * Oblicza różnicę czasu pomiędzy wszystkimi markerami
     * 
     * @param bool $hidden - czy zwrócić dane jako tablica (true) czy jako wyświetlić jako html (false)
     * @return array
     */
    function total( $show = false )
    {
        $last_used_marker = 'start';
        $data        = array();
        $html        = null;
 
        foreach( $this as $key => $value )
        {
            $data['markers'][$key]  = $this->display( $last_used_marker, $key );
            $last_used_marker       = $key;
            $html .= '<b>'. $data['markers'][$key] . '</b> - '. $key ."<br />";
        }
        $data['summery'] = $this->display();
        $html .= '<b>'. $data['summery'] . " - total execution time</b>";
 
        if( $show == false )
        {
            return $data;
        }
        else
        {
            echo $html;
        }
    }
}
?>
