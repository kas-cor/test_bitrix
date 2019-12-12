<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->addExternalCss("//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css");
$this->addExternalJS("//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js");
$this->addExternalJS("//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js");
?>

<script>
    BX.message({
        TEST_COMPONENT_NAME: '<?= $component->GetName() ?>',
        TEST_COMPONENT_HIGHLOADBLOCKID: '<?= $arParams['highLoadBlockId'] ?>',
    });
</script>

<div class="books_cont">
    <?php
    if ($_GET['is_ajax'] == 'y') {
        $APPLICATION->RestartBuffer();
    }
    ?>

    <form class="form-inline books_form">
        <div class="form-group mb-2">
            <input type="text" name="name" placeholder="Название книги" class="form-control" required/>
        </div>
        <div class="form-group mb-2">
            <input type="text" name="year" placeholder="Год выпуска" class="form-control" required/>
        </div>
        <div class="form-group mb-2">
            <input type="text" name="author" placeholder="Имя автора" class="form-control"/>
        </div>
        <div class="form-group mb-2">
            <input type="text" name="desc" placeholder="Дополнительное описание" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Добавить</button>
    </form>

    <table class="books_table">
        <thead>
        <tr>
            <td>Название книги</td>
            <td>Год выпуска</td>
            <td>Имя автора</td>
            <td>Дополнительное описание</td>
            <td>Удалить</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arResult['books'] as $item): ?>
            <tr data-id="<?= $item['ID'] ?>">
                <td><?= $item['UF_NAME'] ?></td>
                <td><?= $item['UF_YEAR'] ?></td>
                <td><?= $item['UF_AUTHOR'] ?></td>
                <td><?= $item['UF_DESC'] ?></td>
                <td>
                    <a href="javascript:void(0);" class="books_action_delete"><img src="<?= $this->GetFolder() ?>/images/icon-delete.png" alt="Удалить"/></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    if ($_GET['is_ajax'] == 'y') {
        die();
    }
    ?>
</div>
