<?php

namespace Core\Patterns;

trait Singleton {
    private static $instance = null;

    private function __construct() { }  // Защищаем от создания через new Singleton
    private function __clone() { }  // Защищаем от создания через клонирование
    private function __wakeup() { }  // Защищаем от создания через unserialize

    public static function getInstance() {
		return 
		self::$instance===null
			? self::$instance = new static() // Если $instance равен 'null', то создаем объект new self()
			: self::$instance; // Иначе возвращаем существующий объект 
    }
}