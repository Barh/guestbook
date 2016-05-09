<!-- Comment insert -->
<div class="gb-comment-insert">
    <form method="post">
        <table>
            <tr>
                <td style="width: 1%;">
                    <div>
                        <label><?php echo Language::get('main', 'form_email'); ?></label>
                    </div>
                </td>
                <td style="width: 1%;">
                    <div class="gb-comment-insert-email">
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
                    <div class="gb-comment-insert-submit">
                        <input type="submit" name="insert" value="<?php echo Language::get('comments', 'insert'); ?>" />
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>