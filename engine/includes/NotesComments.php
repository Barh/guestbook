<?php

    class NotesComments
    {
        /**
         * Table
         * @var string
         */
        private static $table;

        /**
         * Limit notes comments
         * @var int
         */
        private static $limit = 2;

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

        /**
         * Get list
         * @param int $note_id note_id
         * @param int|null $id id
         * @param bool $before before?
         * @param bool $no_limit no limit?
         * @return bool
         */
        public static function getList($note_id, $id = null, $before = false, $no_limit = false)
        {
            // forming sql and data
            $sql = '';
            $data['note_id'] = $note_id;
            if (!is_null($id)) { // start defined
                $sql = " and `id` ".($before ? '<' : '>')." :id";
                $data['id'] = $id;
            }
            // order
            $sql .= ' order by `id` '.($before ? 'desc' : 'asc');
            // limit
            if (!$no_limit) {
                $sql .= ' limit '.self::$limit;
            }

            // select
            if ($array = DBSite::query("select * from `".self::getTable()."` where `note_id` = :note_id ".$sql, $data) ) {
                return $array;
            } else { // no is
                return false;
            }
        }
    }