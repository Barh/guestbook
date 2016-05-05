<?php

    class NotesComments
    {
        /**
         * Table
         * @var string
         */
        private static $table;

        /**
         * Init
         */
        public static function init()
        {
            self::$table = DBSite::$data['db_prefix'].'notes_comments';
        }

        /**
         * Get table
         * @return string
         */
        public static function getTable()
        {
            return self::$table;
        }

        /**
         * Insert
         * @param array $data data
         * @return int|bool
         */
        public static function insert($data)
        {
            // for query
            $data = Parameters::forQuery($data);

            // insert
            if (DBSite::query("insert into `".self::getTable()."` (".$data[1].") values (".$data[2].")", $data[0]) ) {
                // last id
                return DBSite::lastInsertId();
            } else { // no insert
                return false;
            }
        }
    }