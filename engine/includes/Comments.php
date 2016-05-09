<?php

    /**
     * Class Comments
     */
    class Comments extends RecordStructure
    {
        /**
         * Construct
         */
        public function construct()
        {
            // default properties
            $this->setAfter();
            $this->setOrderAsc();
        }

        /**
         * Set anchor id
         * @param int $anchor_id anchor id
         */
        public function setAnchorId($anchor_id)
        {
            $this->setAnchor('note_id', (int)$anchor_id);
        }
    }