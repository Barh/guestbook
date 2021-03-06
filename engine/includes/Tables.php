<?php

    class Tables
    {
        /**
         * Tables
         * @var
         */
        private static $tables;

        /**
         * Init
         */
        public static function init()
        {
            // set tables
            foreach (array('notes', 'comments') as $v) {
                self::$tables[$v] = DBSite::$data['db_prefix'].$v;
            }
        }

        /**
         * Get
         * @param string $type type
         * @return string|bool
         */
        public static function get(RecordStructure $type)
        {
            if ($type instanceof Notes) {
                return self::$tables['notes'];
            } else if ($type instanceof Comments) {
                return self::$tables['comments'];
            } else {
                return false;
            }
        }

        /**
         * Is
         */
        public static function is()
        {
            return (bool)DBSite::query(
                "SHOW TABLES LIKE '".self::$tables['notes']."'"
            );
        }

        /**
         * Create
         */
        public static function create()
        {
            // notes, notes comments
            DBSite::query(
                "CREATE TABLE IF NOT EXISTS `".self::$tables['notes']."` (
  `id` int(6) unsigned NOT NULL,
  `name` varchar(36) NOT NULL,
  `email` varchar(36) NOT NULL,
  `text` text NOT NULL,
  `image` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `".self::$tables['notes']."`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `".self::$tables['notes']."`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT;
CREATE TABLE IF NOT EXISTS `".self::$tables['comments']."` (
  `id` int(6) unsigned NOT NULL,
  `note_id` int(6) unsigned NOT NULL,
  `email` varchar(36) NOT NULL,
  `text` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `".self::$tables['comments']."`
  ADD PRIMARY KEY (`id`), ADD KEY `note_id` (`note_id`);
ALTER TABLE `".self::$tables['comments']."`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT;"
            );
        }

        /**
         * Drop tables
         */
        public static function drop()
        {
            foreach (self::$tables as $v) {
                DBSite::query("DROP TABLE IF EXISTS `".$v."`;");
            }
        }

        /**
         * Drop tables
         */
        public static function fill()
        {
            // drop
            self::drop();

            // create
            self::create();

            // fill data
            include_once __DIR__.'/../fill.php';

            // insert data
            $note = new Notes();
            foreach ($notes as $v) {
                $note->insert($v);
            }
        }
    }