<?php

namespace Core\Helpers;

/**
 * Класс Helper
 *
 * @author Lexing
 */
class Helper {

    /**
     * Переводит дату формата 25/12/2019 в unixtime
     * @param string $date дата
     * @return int Дата в Unixtime
     */
    public static function date_to_unixtime($date){
        $d = explode('/', $date);
        return mktime(0, 0, 0, $d[1], $d[0], $d[2] );
    }
}