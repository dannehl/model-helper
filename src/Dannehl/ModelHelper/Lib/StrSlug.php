<?php namespace Dannehl\ModelHelper\Lib;

/**
 * Class StrSlug
 *
 * @package Dannehl\ModelHelper\Lib
 */
class StrSlug {

    /**
     * @param $string
     * @return mixed
     */
    public static function make($string)
    {
        $uml_s = ['ä', 'ö', 'ü', 'ß', '_'];
        $uml_r = ['ae', 'oe', 'ue', 'ss', '-'];

        return str_slug(str_replace($uml_s, $uml_r, $string));
    }
    
    
}