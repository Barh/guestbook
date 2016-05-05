<?php

    class Notes
    {
        /**
         * Table
         * @var string
         */
        private static $table;

        /**
         * Limit notes
         * @var int
         */
        private static $limit = 2;

        public static function init()
        {
            self::$table = DBSite::$data['db_prefix'].'notes';
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

        /**
         * Get list
         * @param int|null $id id
         * @param bool $before before?
         * @param bool $no_limit no limit?
         * @return bool
         */
        public static function getList($id = null, $before = true, $no_limit = false)
        {
            // forming sql and data
            $sql = '';
            if (is_null($id)) { // start undefined
                $data = array();
            } else { // start defined
                $sql = " where `id` ".($before ? '<' : '>')." :id";
                $data = array('id' => $id);
            }
            // order
            $sql .= ' order by `id` '.($before ? 'desc' : 'asc');
            // limit
            if (!$no_limit) {
                $sql .= ' limit '.self::$limit;
            }

            // select
            if ($array = DBSite::query("select * from `".self::getTable()."` ".$sql, $data) ) {
                return $array;
            } else { // no is
                return false;
            }
        }
    }