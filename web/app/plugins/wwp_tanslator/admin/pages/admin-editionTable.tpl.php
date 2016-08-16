<?php

$editionTable = $values['editionTable'];

if (!empty($editionTable)): ?>
    <form method="post">
        <table class="widefat">
            <?php
            if (!empty($editionTable['headers'])) {
                echo '<tr>';
                foreach ($editionTable['headers'] as $th) {
                    echo '<th>' . $th . '</th>';
                }
                echo '</tr>';
            }

            if (!empty($editionTable['hidden'])) {
                echo'<tr class="hidden">';
                foreach ($editionTable['hidden'] as $i=>$row) { ?>
                    <td><textarea name="<?php echo $i; ?>[headers]"><?php echo $row; ?></textarea></td>
                    <?php
                }}
            echo'</tr>';

            if (!empty($editionTable['body'])) {
                foreach ($editionTable['body'] as $row) {
                    echo '<tr>';
                    if (!empty($row)) {
                        foreach ($row as $i => $cell) {
                            echo '<td><input type="text" class="text '.( $i == 'pot' ? 'disabled' : '' ).'" value="' . $cell . '" name="' . $i . '[lines][]" /></td>';
                        }
                    }
                    echo '</tr>';
                }
            }
            ?>

        </table>
        <div class="submitWrap">
            <input class="btn button" type="submit" value="Sauvegarder" />
        </div>
    </form>
<?php endif; ?>