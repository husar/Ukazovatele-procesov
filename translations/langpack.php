<?php
abstract class langpack {
    public static $language = array();

    public static function get($n) {
        return isset(self::$language[$n]) ? self::$language[$n] : null;
    }
}
?>