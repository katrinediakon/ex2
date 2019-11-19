<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

if (!Loader::includeModule("iblock")) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
    return;
}
global $CACHE_MANAGER;

if (intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0) {
    if ($this->StartResultCache()) {
        $user = array();
        $thisUser = $USER->GetID();
        $arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL");
        $arFilter = Array("IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"], "PROPERTY_USER" => $thisUser, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        while ($ob = $res->GetNext()) {
            $item = array();
            $item['NAME'] = $ob['NAME'];
            $item['PRICE'] = $ob['PROPERTY_PRICE_VALUE'];
            $item['ARTNUMBER'] = $ob['PROPERTY_ARTNUMBER_VALUE'];
            $item['MATERIAL'] = $ob['PROPERTY_MATERIAL_VALUE'];

            $arResult['ITEM'][$ob['ID']] = $item;
            foreach ($ob['PROPERTY_USER_VALUE'] as $itemUser) {
                if ($itemUser != $thisUser) {
                    $user[] = $itemUser;
                }
            }
        }

        $arSelect = Array("ID", "NAME", "PROPERTY_USER", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL");
        $arFilter = Array("IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"], "PROPERTY_USER" => $user, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        $user = array();
        while ($ob = $res->GetNext()) {
            $item = array();
            $item['NAME'] = $ob['NAME'];
            $item['PRICE'] = $ob['PROPERTY_PRICE_VALUE'];
            $item['ARTNUMBER'] = $ob['PROPERTY_ARTNUMBER_VALUE'];
            $item['MATERIAL'] = $ob['PROPERTY_MATERIAL_VALUE'];

            $arResult['OTHER_USER'][$ob['ID']] = $item;
            foreach ($ob['PROPERTY_USER_VALUE'] as $itemUser) {
                if ($itemUser != $thisUser) {
                    $arResult['OTHER_USER'][$ob['ID']]['USER'][$itemUser] = $itemUser;
                    $user[] = $itemUser;
                }
            }
        }
        $arSel = array('ID', 'LOGIN');
        $filter = Array("ID" => $user);
        $rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter, array("FIELDS" => $arSel));
        while ($arUser = $rsUsers->Fetch()) {
            foreach ($arResult['OTHER_USER'] as $key => $news) {
                if ($news['USER'][$arUser['ID']]) {
                    $arResult['OTHER_USER'][$key]['USER'][$arUser['ID']] = $arUser['LOGIN'];
                }
            }
        }
        $CACHE_MANAGER->RegisterTag("iblock_id_new");
        $arResult['COUNT'] = count($arResult['ITEM']);
        $this->SetResultCacheKeys(array('COUNT'));
    }
}

$APPLICATION->SetTitle("Избранных элементов: " . $arResult['COUNT']);
$this->includeComponentTemplate();
?>