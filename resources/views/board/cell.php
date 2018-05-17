<?php
/**
 * @var $cell \tratabor\interfaces\basics\ICell
 */
?>
<a href="/?from_cell=&to_cell=<?=$cell->getId()?>" title="Перейти в эту клетку">
    <div class="p-1 gm-field-cell">
        <?php
        // echo $cell->getContain()
        // ICellSnag implements __toString()
        ?>
    </div>
</a>