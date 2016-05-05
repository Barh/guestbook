$(function() {

    /**
     * Main
     * @constructor
     */
    gb_Main = function ()
    {
        var self = this;

        /**
         * Selectors
         * @type {Object}
         */
        this.selectors =
        {
            'note' : '.gb-note',
            'notes' : '.gb-notes',
            'notes_more_submit' : '.gb-notes-more input[type=submit]',
            'note_insert_submit'  : '.gb-note-insert input[name=insert]',
            'note_comment_insert_submit'  : '.gb-note-comment-insert input[name=insert]'
        };

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
        this.values = {};

        /**
         * Init
         */
        this.init = function()
        {
            // init note html
            self.initNoteHtml();

            // init notes
            self.initNotes();

            // init notes more
            self.initNotesMore();

            // init note insert
            self.initNoteInsert();

            // init comments insert
            self.initNoteCommentInsert();
        };

        /**
         * Init note html
         */
        this.initNoteHtml = function()
        {
            self.elements.note = ($(self.selectors.note).remove().removeAttr('data-template'))[0].outerHTML;
        };

        /**
         * Get note html
         * @param {Object} data data
         * @return {String}
         */
        this.getNoteHtml = function(data)
        {
            var note = $(self.elements.note);
            note.attr('data-id', data.id);
            note.find('[data-name]').text(data.name);
            note.find('[data-email]').text(data.email);
            note.find('[data-text]').text(data.text);
            note.find('[data-comments]').text(data.comments);
            return note[0].outerHTML;
        };

        /**
         * Init notes
         */
        this.initNotes = function()
        {
            // object notes
            self.objects.notes = $(self.selectors.notes)[0];

            // get notes
            self.getNotes();
        };

        /**
         * Get notes
         * @param {Number} id
         * @param {Number} before 1|0
         * @param {Number} no_limit 1|0
         */
        this.getNotes = function(id, before, no_limit)
        {
            // available request
            if ( self.requests.notes_get === undefined || self.requests.notes_get.readyState === 4 )
            {
                // set props
                var props = {};
                if (typeof id !== 'undefined') {
                    props.id = id;
                }

                if (typeof before !== 'undefined') {
                    props.before = before;
                }

                if (typeof no_limit !== 'undefined') {
                    props.no_limit = no_limit;
                }

                // send request
                self.requests.notes_get = $.ajax({
                    url       : '?q=notes',
                    type      : 'POST',
                    dataType  : 'json',
                    traditional : true,
                    data      : props,
                    success   : function(data)
                    {
                        // success
                        if (data.result) {
                            // обновить список записей
                            if (typeof props.before !== 'undefined') {
                                self.addHtmlNotes(data.data, props.before);
                            } else {
                                self.addHtmlNotes(data.data);
                            }
                        }
                    }
                });
            }
        };

        /**
         * Add html notes
         * @param {Array} data
         * @param {Boolean} before
         */
        this.addHtmlNotes = function(data, before)
        {
            // set before
            if (typeof before === 'undefined')
                before = true;

            // each notes
            for (var key in data) {
                // insert to html
                var note = self.getNoteHtml(data[key]);
                if (before) {
                    $(self.objects.notes).append(note);
                } else {
                    $(self.objects.notes).prepend(note);
                }
            }

            // set notes id
            self.setNoteLastId();
            self.setNoteFirstId();
        };

        /**
         * Set note last id
         */
        this.setNoteLastId = function()
        {
            self.values.notes_id_last = $(self.objects.notes).find(self.selectors.note).first().attr('data-id');
        };

        /**
         * Set note first id
         */
        this.setNoteFirstId = function()
        {
            self.values.notes_id_first = $(self.objects.notes).find(self.selectors.note).last().attr('data-id');
        };

        /**
         * Init notes more
         */
        this.initNotesMore = function()
        {
            $(self.selectors.notes_more_submit).click(function() {
                self.getNotes(self.values.notes_id_first);
                return false;
            });
        };

        /**
         * Init note insert
         */
        this.initNoteInsert = function()
        {
            // get object insert button
            self.objects.note_insert_submit = $(self.selectors.note_insert_submit).eq(0)[0];

            // click insert button
            $(self.objects.note_insert_submit).click(function() {
                // get form
                var form = $(this).parents('form').eq(0);

                // get parameters post
                var params_post = form.serializeArray();

                // insert AJAX
                self.insertNote(params_post);

                return false;
            });
        };

        /**
         * Insert note
         * @param {Array} props properties
         */
        this.insertNote = function(props)
        {
            // available request
            if ( self.requests.note_insert === undefined || self.requests.note_insert.readyState === 4 )
            {
                // send request
                self.requests.note_insert = $.ajax({
                    url       : '?q=notes/insert',
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
                            // get notes
                            self.getNotes(self.values.notes_id_last, 0, 1);
                            // clear form
                            self.clearNoteInsertForm();
                        }
                    }
                });
            }
        };

        /**
         * Clear note insert form
         */
        this.clearNoteInsertForm = function()
        {
            $(self.objects.note_insert_submit).parents('form').eq(0)[0].reset();
        };

        /**
         * Init note comment insert
         */
        this.initNoteCommentInsert = function()
        {
            // click insert button
            $(document).on('click', self.selectors.note_comment_insert_submit, function() {
                // get form
                var form = $(this).parents('form').eq(0);

                // get parameters post
                var params_post = form.serializeArray();

                // note id
                var note_id = $(this).parents(self.selectors.note).eq(0).attr('data-id');

                // insert AJAX
                self.insertNoteComment(note_id, params_post);

                return false;
            });
        };

        /**
         * Insert note comment
         * @param {Number} note_id note id
         * @param {Array} props properties
         */
        this.insertNoteComment = function(note_id, props)
        {
            // available request
            if ( self.requests.note_comment_insert === undefined || self.requests.note_comment_insert.readyState === 4 )
            {
                // send request
                self.requests.note_comment_insert = $.ajax({
                    url       : '?q=notes/' + note_id + '/comments/insert',
                    type      : 'POST',
                    dataType  : 'json',
                    traditional : true,
                    data      : props,
                    success   : function(data)
                    {
                        // message
                        /*alert(data.message);

                        // success
                        if (data.result) {
                            // get notes
                            self.getNotes(self.values.notes_id_last, 0, 1);
                            // clear form
                            self.clearNoteInsertForm();
                        }*/
                    }
                });
            }
        };
    };

    // init
    document.gb_Main = new gb_Main(); document.gb_Main.init();
});