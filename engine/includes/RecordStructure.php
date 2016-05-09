<?php

    /**
     * Class RecordStructure
     */
    abstract class RecordStructure
    {
        /**
         * Properties
         * @var array
         */
        protected $props = array(
            'id'      => 0,
            'before'  => false,
            'limit'   => 2,
            'order'   => false,
        );

        /**
         * Construct
         */
        public function __construct()
        {
            // set table
            $this->table = Tables::get($this);
            // construct
            $this->construct();
        }

        /**
         * Set id
         * @param $id
         */
        public function setId($id)
        {
            $this->props['id'] = (int)$id;
        }

        /**
         * Set before
         */
        public function setBefore()
        {
            $this->props['before'] = true;
        }

        /**
         * Set before
         * @param $bool
         */
        public function setAfter()
        {
            $this->props['before'] = false;
        }

        /**
         * Set limit
         * @param int $limit limit
         */
        public function setLimit($limit)
        {
            $this->props['limit'] = (int)$limit;
        }

        /**
         * Set no limit
         */
        public function setNoLimit()
        {
            $this->setLimit(0);
        }

        /**
         * Set order desc
         */
        public function setOrderAsc()
        {
            $this->props['order'] = 'asc';
        }

        /**
         * Set anchor
         * @param string $key key
         * @param int $value value
         */
        public function setAnchor($key, $value)
        {
            $this->props['anchor']['key'] = $key;
            $this->props['anchor']['value'] = $value;
        }

        /**
         * Insert
         * @param array $data data
         * @return int|bool
         */
        public function insert($data)
        {
            // for query
            $data = Parameters::forQuery($data);

            // insert
            if (DBSite::query("insert into `".$this->table."` (".$data[1].") values (".$data[2].")", $data[0]) ) {
                // last id
                return DBSite::lastInsertId();
            } else { // no insert
                return false;
            }
        }

        /**
         * Get list
         * @return array|bool
         */
        public function getList()
        {
            // init variables
            $sql = '';
            $data = array();
            $where = false;

            if (isset($this->props['anchor'])) {
                $where = true;
                $sql = "`".$this->props['anchor']['key']."` = :".$this->props['anchor']['key'];
                $data[$this->props['anchor']['key']] = $this->props['anchor']['value'];
            }

            // defined id
            if ($this->props['id']) {
                $where = true;
                $sql .= ($sql ? ' and ' : '')."`id` ".($this->props['before'] ? '<' : '>')." :id";
                $data['id'] = $this->props['id'];
            }

            // where
            if ($where) {
                $sql = 'where '.$sql;
            }

            // order
            if ($this->props['order']) {
                $sql .= ' order by `id` '.$this->props['order'];
            } else {
                $sql .= ' order by `id` '.($this->props['before'] ? 'desc' : 'asc');
            }

            // limit
            if ($this->props['limit']) {
                $sql .= ' limit '.$this->props['limit'];
            }

            // select
            if ($array = DBSite::query("select * from `".$this->table."` ".$sql, $data) ) {
                return $array;
            } else { // no is
                return false;
            }
        }
    }