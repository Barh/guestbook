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
            self::$tables = array(
                'notes' => Notes::getTable(),
                'notes_comments' => NotesComments::getTable(),
            );
        }

        /**
         * Is
         */
        public static function is()
        {
            return (bool)DBSite::query(
                "SHOW TABLES LIKE '".Notes::getTable()."'"
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
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `image` tinyint(1) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `".self::$tables['notes']."`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `".self::$tables['notes']."`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT;
CREATE TABLE IF NOT EXISTS `".self::$tables['notes_comments']."` (
  `id` int(6) unsigned NOT NULL,
  `note_id` int(6) unsigned NOT NULL,
  `email` varchar(20) NOT NULL,
  `text` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `".self::$tables['notes_comments']."`
  ADD PRIMARY KEY (`id`), ADD KEY `note_id` (`note_id`);
ALTER TABLE `".self::$tables['notes_comments']."`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT;"
            );
        }
    }