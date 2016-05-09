<!-- Note -->
<div class="gb-note" data-template>
    <!-- Title -->
    <div class="gb-note-title">
        <span data-name></span>
        <span class="gb-note-email">(<span data-email></span>)</span>
        <span class="gb-note-id">#<span data-id></span></span>
    </div>
    <!-- Created time -->
    <div data-created></div>
    <div class="clear"></div>
    <!-- Text -->
    <div data-text></div>
    <?php include_once 'comments.php'; ?>
    <!-- Comments more -->
    <div class="gb-comments-more">
        <input type="submit" value="<?php echo Language::get('comments', 'more'); ?>" />
    </div>
    <?php include 'comment_insert.php'; ?>
</div>