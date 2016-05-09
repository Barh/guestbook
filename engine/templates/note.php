<!-- Note -->
<div class="gb-note" data-template>
    <div class="gb-note-title">
        <span data-name></span>
        <span class="gb-note-email">(<span data-email></span>)</span>
        <span class="gb-note-id">#<span data-id></span></span>
    </div>
    <div data-created></div>
    <div class="clear"></div>
    <div data-text></div>
    <?php include_once 'note_comments.php'; ?>
    <!-- Note comments more -->
    <div class="gb-note-comments-more">
        <input type="submit"  value="<?php echo Language::get('comments', 'more'); ?>" />
    </div>
    <?php include 'note_comment_insert.php'; ?>
</div>