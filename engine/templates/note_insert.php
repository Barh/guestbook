<!-- Note insert -->
<div class="gb-note-insert">
    <form method="post">
        <table>
            <!-- Title -->
            <tr>
                <td colspan="2">
                    <div class="gb-note-title"><?php echo Language::get('notes', 'title'); ?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Имя:</label>
                </td>
                <td>
                    <input type="text" name="name" value="" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="gb-note-email">E-mail:</label>
                </td>
                <td>
                    <input type="text" name="email" value="" id="gb-note-email" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="gb-note-text">Сообщение:</label>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="text" id="gb-note-text"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="insert" value="<?php echo Language::get('notes', 'insert'); ?>" id="gb-note-email" />
                </td>
            </tr>
        </table>
    </form>
</div>