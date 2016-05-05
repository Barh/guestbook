<!-- Note -->
<div class="gb-note" data-template>
    <div data-name></div>
    <div data-email></div>
    <div data-text></div>
    <?php include_once 'note_comments.php'; ?>
    <!-- Note comments more -->
    <div class="gb-note-comments-more">
        <input type="submit"  value="<?php echo Language::get('notes_comments', 'more'); ?>" />
    </div>
    <?php include_once 'note_comment_insert.php'; ?>
</div>