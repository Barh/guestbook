<!-- Note comment insert -->
<div class="gb-note-comment-insert">
    <form method="post">
        <table>
            <tr>
                <td style="width: 1%;">
                    <div>
                        <label><?php echo Language::get('main', 'form_email'); ?></label>
                    </div>
                </td>
                <td style="width: 1%;">
                    <div class="gb-note-comment-insert-email">
                        <input type="text" name="email" value="" autocomplete="off" />
                    </div>
                </td>
                <td style="width: 1%;">
                    <div>
                        <label><?php echo Language::get('main', 'form_text'); ?></label>
                    </div>
                </td>
                <td>
                    <div>
                        <textarea name="text" id="gb-note-text"></textarea>
                    </div>
                </td>
                <td style="width: 1%;">
                    <div class="gb-note-comment-insert-submit">
                        <input type="submit" name="insert" value="<?php echo Language::get('comments', 'insert'); ?>" />
                    </div>
                </td>
            </tr>
        </table>
        <?php /*
        <table>
            <tr>
                <td>
                    <div>
                        <label><?php echo Language::get('main', 'form_email'); ?></label>
                    </div>
                </td>
                <td>
                    <div class="gb-insert-field">
                        <input type="text" name="email" value="" id="gb-note-email" />
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <label><?php echo Language::get('main', 'form_text'); ?></label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <textarea name="text"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="gb-insert-submit">
                        <input type="submit" name="insert" value="<?php echo Language::get('notes_comments', 'insert'); ?>" />
                    </div>
                </td>
            </tr>
        </table> */ ?>
    </form>
</div>