<?php

if (!empty($editionTable)): ?>
    <form method="post" class="keyTableEditor">
        <table class="widefat">
            <?php
            if (!empty($editionTable['headers'])) {
                echo '<tr>';
                foreach ($editionTable['headers'] as $th) {
                    echo '<th>' . $th . '</th>';
                }
                echo '<th class="actionsCol">&nbsp;</th>';//Actions
                echo '</tr>';
            }

            if (!empty($editionTable['hidden'])) {
                echo'<tr class="hidden">';
                foreach ($editionTable['hidden'] as $i=>$row) { ?>
                    <td><textarea name="<?php echo $i; ?>[headers]"><?php echo $row; ?></textarea></td>
                    <?php
                }}
            echo '<td class="actionsCol">&nbsp;</td>';//Actions
            echo'</tr>';

            if (!empty($editionTable['body'])) {
                foreach ($editionTable['body'] as $row) {
                    echo '<tr>';
                    if (!empty($row)) {
                        foreach ($row as $i => $cell) {
                            echo '<td><input type="text" class="text '.( $i == 'pot' ? 'disabled' : '' ).'" value="' . $cell . '" name="' . $i . '[lines][]" /></td>';
                        }
                    }
                    echo '<td class="actionsCol"><button class="rowDeleter">'. __( 'Delete' ).'</button></td>';//Actions
                    echo '</tr>';
                }
            }
            ?>

        </table>
        <div class="submitWrap">
            <button class="btn button rowAdder"><?php echo __( 'Add New' ); ?></button>
            <input class="btn button" type="submit" value="<?php echo __( 'Save' ); ?>" />
        </div>
    </form>
<?php endif; ?>