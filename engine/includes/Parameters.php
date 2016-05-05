<?php

    /**
     * Class Parameters
     */
    class Parameters
    {
        /**
         * Key parameters
         * @var string
         */
        private static $key = 'q';

        /**
         * Parameters
         * @var
         */
        private static $parameters;

        /**
         * Incorrect parameters (flag)
         * @var int
         */
        public static $incorrect = 0;

        /**
         * Get parameters array
         * @return array|bool
         */
        public static function get()
        {
            // need calculate parameters
            if (!isset(self::$parameters)) {
                // parameters sended
                if ( isset($_GET[self::$key]) ) {
                    // get array parameters from GET data
                    $parameters =
                        array_values(
                            array_filter(
                                explode('/', $_GET[self::$key]), function($v) { return (bool)trim($v); }
                            )
                        );

                    // correct parameters
                    if ($parameters) {
                        self::$parameters = $parameters;
                    } else { // incorrect parameters
                        self::$incorrect = 1;
                    }
                }

                // no parameters or incorrect
                if (!isset(self::$parameters)) {
                    self::$parameters = false;
                }
            }

            return self::$parameters;
        }

        /**
         * Incorrect
         */
        public static function incorrect()
        {
            die('Incorrect parameters.');
        }

        /**
         * Получить данные для запроса (PDO, OCI8 и аналогов)
         * @param array $data Массив с корректными ключами и значениями
         * @param bool $allow Массив с обязательными значениями
         * @param bool $accuracy Конечный массив должен в точности соответствовать по количеству элементов фильтру?
         * @return array|bool
         */
        public static function forQuery($data, $allow = false, $accuracy = false)
        {
            // Фильтруем
            if ($allow)
                if (!$data = self::filter($data, $allow, $accuracy))
                    return false;

            // Получаем символ экранирования
            $screening = ( ($classname = self::getCalledClass(2)) && isset($classname::$db) && ($classname = $classname::$db) && isset($classname::$data['screening']) ) ? $classname::$data['screening'] : '`';

            // Формируем строки для запроса
            $sql_1 = $sql_2 = $sql_3 = '';
            foreach ($data as $k=>$v) { $sql_1 .= $screening.$k.$screening.','; $sql_2 .= ':'.$k.','; $sql_3 .= $screening.$k.$screening.'=:'.$k.','; }
            $sql_1 = substr($sql_1, 0, -1); $sql_2 = substr($sql_2, 0, -1); $sql_3 = substr($sql_3, 0, -1);

            return array( $data, $sql_1, $sql_2, $sql_3 );
        }

        /**
         * Фильтруем данные массива
         * @param array $data Массив с корректными ключами и значениями
         * @param array $allow Массив с обязательными значениями
         * @param bool $accuracy Конечный массив должен в точности соответствовать по количеству элементов фильтру?
         * @return array|bool
         */
        public static function filter($data, $allow, $accuracy = false)
        {
            // Фильтруем данные
            foreach ($allow as $v)
                if ( array_key_exists($v, $data) ) {
                    $array[$v] = $data[$v];
                }

            // Возвращаем (с жёсткой фильтрацией или нет)
            return isset($array) ? (!$accuracy ? $array : (count($array) == count($allow) ? $array : false)) : false;
        }

        /**
         * Получить имя класса, функции из которого(-ой) был вызван
         * @param string $type class|function
         * @param int $level уровень вложенности
         */
        private static function getCalled( $type, $level )
        {
            $tree = debug_backtrace();

            if ( $level == 'first' )
                $level = count($tree) - 3;

            return !empty( $tree[$level][$type] ) ? $tree[$level][$type] : '';
        }

        /**
         * Получить имя класса из которого был вызван метод
         * @param int $level уровень вложенности
         * @return mixed
         */
        public static function getCalledClass( $level = 4 )
        {
            return self::getCalled('class', $level);
        }
    }