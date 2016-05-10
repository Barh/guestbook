<!-- Note insert -->
<div class="gb-note-insert gb-insert">
    <form method="post">
        <table>
            <!-- Title -->
            <tr>
                <td colspan="2">
                    <div class="gb-insert-title"><?php echo Language::get('notes', 'title'); ?></div>
                </td>
            </tr>
            <!-- Name -->
            <tr>
                <td>
                    <div>
                        <label for="gb-note-name"><?php echo Language::get('main', 'form_name'); ?></label>
                    </div>
                </td>
                <td>
                    <div class="gb-insert-field">
                        <input type="text" name="name" value="" id="gb-note-name" autocomplete="off" />
                    </div>
                </td>
            </tr>
            <!-- Email -->
            <tr>
                <td>
                    <div>
                        <label for="gb-note-email"><?php echo Language::get('main', 'form_email'); ?></label>
                    </div>
                </td>
                <td>
                    <div class="gb-insert-field">
                        <input type="text" name="email" value="" id="gb-note-email" autocomplete="off" />
                    </div>
                </td>
            </tr>
            <!-- Text -->
            <tr>
                <td colspan="2">
                    <div>
                        <label for="gb-note-text"><?php echo Language::get('main', 'form_text'); ?></label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <textarea name="text" id="gb-note-text"></textarea>
                    </div>
                </td>
            </tr>
            <!-- Submit -->
            <tr>
                <td colspan="2">
                    <div class="gb-insert-submit">
                        <input type="submit" name="insert" value="<?php echo Language::get('notes', 'insert'); ?>" id="gb-note-email" />
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>