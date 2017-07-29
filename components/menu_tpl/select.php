<option value="<?= $category['id'] ?>"
    <?php if($this->model->parent_id == $category['id']) echo ' selected'; //делаем категорию выбранной по умолчанию?>
    <?php if($this->model->parent_id == $category['id']) echo ' disabled'; //делаем категорию невозможной для выбора?>>
    <?= $tab . $category['name'] ?>
</option>

<?php if(isset($category['childs'])) : ?>
    <ul>
        <?= $this->getMenuHtml($category['childs'], $tab . '---') ?>
    </ul>
<?php endif; ?>