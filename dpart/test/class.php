<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Entity;
use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;

/**
 * Class Test
 */
class Test extends CBitrixComponent implements Controllerable {

    /**
     * @var int ID HighLoadBlock
     */
    private $highLoadBlockId;

    /**
     * @param array $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams) {
        $this->highLoadBlockId = $arParams['highLoadBlockId'];

        return $arParams;
    }

    /**
     * @inheritDoc
     */
    public function executeComponent() {
        $entity_data_class = self::getHighloadblock($this->highLoadBlockId);
        $rsData = $entity_data_class::getList([
            "select" => ["*"],
            "order" => ["ID" => "ASC"],
        ]);
        while ($arData = $rsData->Fetch()) {
            $this->arResult['books'][] = $arData;
        }

        $this->includeComponentTemplate();
    }

    /**
     * @inheritDoc
     */
    public function configureActions() {
        return [
            'add' => [
                'prefilters' => [],
            ],
            'delete' => [
                'prefilters' => [],
            ],
        ];
    }

    /**
     * Добавление записи
     * @param int $highLoadBlockId
     * @param string $name
     * @param string $year
     * @param string $author
     * @param string $desc
     * @return array
     */
    public static function addAction($highLoadBlockId, $name, $year, $author = '', $desc = '') {
        $result = new Result();
        if (!$highLoadBlockId) {
            $result->addError(new Error('Потеря данных'));
        }
        if (!$name) {
            $result->addError(new Error('Не введено название книги'));
        }
        if (!$year) {
            $result->addError(new Error('Не введен год выпуска'));
        }
        if (!$result->isSuccess()) {
            return AjaxJson::createError($result->getErrorCollection());
        }

        $entity_data_class = self::getHighloadblock($highLoadBlockId);
        $newEntry = $entity_data_class::add([
            'UF_NAME' => $name,
            'UF_YEAR' => $year,
            'UF_AUTHOR' => $author,
            'UF_DESC' => $desc,
        ]);

        return [
            'id' => $newEntry->GetId(),
        ];
    }

    /**
     * Удаление записи
     * @param int $highLoadBlockId
     * @param int $id
     * @return mixed
     */
    public static function deleteAction($highLoadBlockId, $id) {
        $result = new Result();
        if (!$highLoadBlockId && !$id) {
            $result->addError(new Error('Потеря данных'));
        }
        if (!$result->isSuccess()) {
            return AjaxJson::createError($result->getErrorCollection());
        }

        $entity_data_class = self::getHighloadblock($highLoadBlockId);
        $entity_data_class::Delete($id);
    }

    /**
     * Возвращает инстанс HighLoadBlock
     * @param int $id
     * @return mixed
     */
    static function getHighloadblock($id) {
        Loader::includeModule("highloadblock");
        $hlblock = HL\HighloadBlockTable::getById($id)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);

        return $entity->getDataClass();
    }
}
