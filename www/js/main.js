$(function() {

    /**
     * Record
     * @param name
     */
    gb_Record = function(name)
    {
        var self = this;

        /**
         * Selectors
         * @type {Object}
         */
        this.selectors = {};

        /**
         * Elements
         * @type {Object}
         */
        this.elements = {};

        /**
         * Objects (DOM)
         * @type {Object}
         */
        this.objects = {};

        /**
         * Requests
         * @type {Object}
         */
        this.requests = {};


        /**
         * Values
         * @type {Object}
         */
        this.values = {
            'before' : 0,
            'fields' : ['email', 'id', 'created', 'text']
        };

        /**
         * Instance
         * @type {Object}
         */
        this.instance = {};

        /**
         * Init
         * @param {Function} object
         */
        this.init = function(object)
        {
            // set instance
            self.instance = object;
            self.instance.init(self);

            // set selectors
            self.selectors['record']        = '.gb-' + self.values.name;
            self.selectors['records']       = '.gb-' + self.values.name + 's';
            self.selectors['more_submit']   = '.gb-' + self.values.name + 's-more input[type=submit]';
            self.selectors['insert_submit'] = '.gb-' + self.values.name + '-insert input[type=submit]';

            // init record html
            self.initRecordHtml();

            // init records
            self.instance.initRecords(self);

            // init records more
            self.initRecordsMore();

            // init record insert
            self.initRecordInsert();
        };

        /**
         * Set anchor selectors
         * @param {String} name name
         */
        this.setAnchorSelector = function(name)
        {
            self.selectors['anchor'] = '.gb-' + name;
        };

        /**
         * Set anchor id
         * @param {Number} id id
         */
        this.setAnchorId = function(id)
        {
            self.values['anchor_id'] = id;
        };

        /**
         * Set id
         * @param {Number} id id
         */
        this.setId = function(id)
        {
            self.values.id = id;
        };

        /**
         * Set before
         */
        this.setBefore = function()
        {
            self.values.before = 1;
        };

        /**
         * Set after
         */
        this.setAfter = function()
        {
            self.values.before = 0;
        };

        /**
         * Set limit
         */
        this.setLimit = function()
        {
            self.values.limit = 1;
        };

        /**
         * Set no limit
         */
        this.setNoLimit = function()
        {
            self.values.limit = 0;
        };

        /**
         * Get url insert
         */
        this.getUrlInsert = function()
        {
            // with anchor id
            if (typeof self.values.anchor_id !== 'undefined') {
                return self.values.url_insert.replace('#', self.values.anchor_id);
            } else { // without
                return self.values.url_insert;
            }
        };

        /**
         * Get url get list
         */
        this.getUrlGetList = function()
        {
            // with anchor id
            if (typeof self.values.anchor_id !== 'undefined') {
                return self.values.url_get_list.replace('#', self.values.anchor_id);
            } else { // without
                return self.values.url_get_list;
            }
        };

        /**
         * Init record html
         */
        this.initRecordHtml = function()
        {
            self.elements.record = ($(self.selectors.record).remove().removeAttr('data-template'))[0].outerHTML;
        };

        /**
         * Get record html
         * @param {Object} data data
         * @return {String} Record html
         */
        this.getRecordHtml = function(data)
        {
            // get record html
            var record = $(self.elements.record);

            // set id attr
            record.attr('data-id', data.id);

            // set data
            for (var key in this.values.fields) {
                record.find('[data-' + this.values.fields[key] + ']').text(data[this.values.fields[key]]);
            }

            return record[0].outerHTML;
        };

        /**
         * Get records
         */
        this.getRecords = function()
        {
            // available request
            if ( self.requests.records_get === undefined || self.requests.records_get.readyState === 4 )
            {
                // set props
                var props = {};

                // id
                if (typeof self.values.id !== 'undefined') {
                    props.id = self.values.id;
                }

                // before
                if (typeof self.values.before !== 'undefined') {
                    props.before = self.values.before;
                }

                // no limit
                if (typeof self.values.limit !== 'undefined') {
                    props.no_limit = self.values.limit ? 0 : 1;
                }

                // send request
                self.requests.records_get = $.ajax({
                    url       : self.getUrlGetList(),
                    type      : 'POST',
                    dataType  : 'json',
                    traditional : true,
                    data      : props,
                    success   : function(data)
                    {
                        // success
                        if (data.result) {
                            // add html records
                            self.addHtmlRecords(data.data);
                        }
                    }
                });
            }
        };

        /**
         * Add html records
         * @param {Array} data
         */
        this.addHtmlRecords = function(data)
        {
            // is anchor id
            var object = {};
            if (typeof self.values.anchor_id !== 'undefined') {
                object = $(self.selectors.anchor + '[data-id=' + self.values.anchor_id + ']').find(self.selectors.records);
            } else { // no is
                object = $(self.selectors.records);
            }

            // each notes
            for (var key in data) {
                // insert to html
                var record = self.getRecordHtml(data[key]);

                // only without anchor id
                if (typeof self.values.anchor_id === 'undefined') {

                    if (self.values.before) {
                        object.append(record);
                    } else {
                        object.prepend(record);
                    }

                    // set record id
                    document.gb_Record['comments'].setAnchorId(data[key]['id']);
                    document.gb_Record['comments'].setRecordId('last');
                    document.gb_Record['comments'].setRecordId('first');
                } else { // with anchor id
                    object.append(record);
                }
            }

            // set records id
            self.setRecordId('last');
            self.setRecordId('first');
        };

        /**
         * Set record id
         */
        this.setRecordId = function(direction)
        {
            // set type
            var type = (direction == 'first' ? 0 : -1);
            // inverse type
            if (typeof self.values.anchor_id === 'undefined') {
                type = (type == -1 ? 0 : -1);
            }

            // is anchor id
            if (typeof self.values.anchor_id !== 'undefined') {

                // create object
                if (typeof self.values['record_id'][self.values.anchor_id] === 'undefined') {
                    self.values['record_id'][self.values.anchor_id] = {};
                }

                // set id
                self.values['record_id'][self.values.anchor_id][direction] =
                    $(self.selectors.anchor + '[data-id=' + self.values.anchor_id + ']').find(self.selectors.record).eq(type).attr('data-id');
            } else { // no is
                // set id
                self.values['record_id_' + direction] =
                    $(self.selectors.records).find(self.selectors.record).eq(type).attr('data-id');
            }
        };

        /**
         * Get record id
         * @param {String} direction first|last
         * @returns {Number}
         */
        this.getRecordId = function(direction)
        {
            // is anchor id
            if (typeof self.values.anchor_id !== 'undefined') {
                return self.values['record_id'][self.values.anchor_id][direction];
            } else { // no is
                return self.values['record_id_' + direction];
            }
        };

        /**
         * Init records more
         */
        this.initRecordsMore = function()
        {
            // click more
            $(document).on('click', self.selectors.more_submit, function() {
                // set properties
                if (typeof self.selectors.anchor !== 'undefined') { // set anchor id
                    self.setAnchorId(
                        $(this).parents(self.selectors.anchor).eq(0).attr('data-id')
                    );
                    self.setId(self.getRecordId('last'));
                    self.setAfter();
                } else {
                    self.setId(self.getRecordId('first'));
                    self.setBefore();
                    self.setLimit();
                }

                // get records
                self.getRecords();

                return false;
            });
        };

        /**
         * Init record insert
         */
        this.initRecordInsert = function()
        {
            // click insert button
            $(document).on('click', self.selectors.insert_submit, function() {
                // set object
                self.objects.insert_submit = this;

                // get form
                var form = $(this).parents('form').eq(0);

                // get parameters post
                var params_post = form.serializeArray();

                // set anchor id
                if (typeof self.selectors.anchor !== 'undefined') {
                    self.setAnchorId(
                        $(this).parents(self.selectors.anchor).eq(0).attr('data-id')
                    );
                }

                // insert AJAX
                self.insertRecord(params_post);

                return false;
            });
        };

        /**
         * Insert record
         * @param {Array} props properties
         */
        this.insertRecord = function(props)
        {
            // available request
            if ( self.requests.record_insert === undefined || self.requests.record_insert.readyState === 4 )
            {
                // send request
                self.requests.record_insert = $.ajax({
                    url       : self.getUrlInsert(),
                    type      : 'POST',
                    dataType  : 'json',
                    traditional : true,
                    data      : props,
                    success   : function(data)
                    {
                        // message
                        alert(data.message);

                        // success
                        if (data.result) {
                            // set id
                            self.setId(self.getRecordId('last'));
                            self.setAfter();
                            self.setNoLimit();

                            // get records
                            self.getRecords();

                            // clear form
                            self.clearRecordInsertForm();
                        }
                    }
                });
            }
        };

        /**
         * Clear record insert form
         */
        this.clearRecordInsertForm = function()
        {
            $(self.objects.insert_submit).parents('form').eq(0)[0].reset();
        };

        // init
        this.init(name);
    };

    /**
     * Notes
     */
    gb_Notes = function ()
    {
        /**
         * Init
         */
        this.init = function(object)
        {
            // name
            object.values.name = 'note';

            // name
            object.values.url_get_list = '?q=notes/#';
            object.values.url_insert   = '?q=notes/insert';

            // fields
            object.values.fields.push('name');

            // default properties
            object.setBefore();
        };

        /**
         * Init records
         */
        this.initRecords = function(object)
        {
            // object records
            object.objects.records = $(object.selectors.records)[0];

            // get records
            object.getRecords();
        };
    };

    /**
     * Comments
     */
    gb_Comments = function ()
    {
        /**
         * Init
         */
        this.init = function(object)
        {
            // name
            object.values.name = 'comment';

            // name
            object.values.url_get_list = '?q=notes/#/comments';
            object.values.url_insert   = '?q=notes/#/comments/insert';

            // set anchor
            object.setAnchorSelector('note');
        };

        /**
         * Init records
         */
        this.initRecords = function(object)
        {
            object.values.record_id = {};
        };
    };

    // Record
    document.gb_Record = {};
    document.gb_Record['comments'] = new gb_Record(new gb_Comments);
    document.gb_Record['notes']    = new gb_Record(new gb_Notes);
});