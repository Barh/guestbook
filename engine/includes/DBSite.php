<?php

    class DBSite
    {
        /**
         * Data, Connection, Last Statement
         * @var
         */
        public static $data, $con, $last;

        /**
         * Init
         */
        public static function init()
        {
            # Data
            self::$data = MainSettings::$db;

            # Connect
            self::connect();
        }

        /**
         * Connect
         * @return PDO
         */
        private static function connect()
        {
            try {
                self::$con = new PDO('mysql:dbname='.self::$data['db_name'].';host='.self::$data['host'].(self::$data['charset'] ? ';charset='.self::$data['charset'] : '').(self::$data['port'] ? ';port='.self::$data['port'] : ''), self::$data['user'], self::$data['password']);
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit;
            }
        }

        /**
         * Query
         * @param string $sql sql-запрос
         * @param array|bool $parameters параметры
         * @return array
         */
        public static function query($sql, $parameters = false)
        {
            # Подготавливает запрос к выполнению
            self::$last = self::$con->prepare($sql);

            # Переданы параметры
            if ( $parameters )
            {
                # Выполняем запрос
                # Ошибка в запуске запроса
                if (!@self::$last->execute($parameters))
                    self::handleError($sql, $parameters);
            }
            # Выполняем запрос
            else
                if (!@self::$last->execute())
                    self::handleError($sql, $parameters);

            # Select
            if (self::$last->columnCount() != 0)
                # Возвращаем ассоциативный массив
                return self::$last->fetchAll(PDO::FETCH_ASSOC);
            # Edit
            else
                return self::$last->rowCount();
        }

        /**
         * Handle error
         * @param string $sql sql-запрос
         * @param array|bool $parameters параметры
         */
        private static function handleError($sql, $parameters)
        {
            # Формируем выводимое сообщение об ошибке
            echo 'Error info:' .print_r(self::$last->errorInfo(), true);
            echo '<br/>Query:' .$sql;
            echo '<br/>Parameters:' .print_r($parameters, true).'<br/>';

            $logs = debug_backtrace();
            if (!empty($logs[1]))
            {
                $log = '';

                if (!empty($logs[1]['class']))
                    $log .= 'class '.$logs[1]['class'].' ';

                if (!empty($logs[1]['function']))
                    $log .= 'function '.$logs[1]['function'].' ';

                if (!empty($log))
                    echo 'Log: ' .$log;
            }

            exit;
        }

        /**
         * Last insert id
         * @return int|mixed
         */
        public static function lastInsertId()
        {
            return self::$con->lastInsertId();
        }
    }