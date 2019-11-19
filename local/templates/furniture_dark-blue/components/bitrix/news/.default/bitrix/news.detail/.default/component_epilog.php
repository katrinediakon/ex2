<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$sidAjax = 'testAjax';
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
    $GLOBALS['APPLICATION']->RestartBuffer();
    $el = new CIBlockElement;
    $PROP = array();
    $PROP[10] = $arParams['ID'];  // свойству с кодом 12 присваиваем значение "Белый"
    $PROP[11] = $USER->GetID();        // свойству с кодом 3 присваиваем значение 38

    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => 5,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => "Новая жалоба",
        "ACTIVE"         => "Y",            // активен
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray))
        echo CUtil::PhpToJSObject(array(
            'RESULT' => 'Жалоба принята, '. $PRODUCT_ID,
            'ERROR' => ''
        ));
    else
        echo CUtil::PhpToJSObject(array(
            'RESULT' => 'Произшла ошибка',
            'ERROR' => ''
        ));
    die();
}

if($_GET['get_form'] == 'Y'){
    $el = new CIBlockElement;
    $PROP = array();
    $PROP[10] = $arParams['ID'];  // свойству с кодом 12 присваиваем значение "Белый"
    $PROP[11] = $USER->GetID();        // свойству с кодом 3 присваиваем значение 38

    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => 5,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => "Новая жалоба",
        "ACTIVE"         => "Y",            // активен
    );
    if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
        LocalRedirect($APPLICATION->GetCurPage()."?VOTE=".$PRODUCT_ID);
    } else {
        LocalRedirect($APPLICATION->GetCurPage()."?VOTE=ERROR");
    }

}
if($_GET['VOTE']) {
    if ($_GET['VOTE'] == 'ERROR') {
        echo "<script > document . getElementById('block').innerHTML = 'Произшла ошибка';
        </script >";
    } else {
        echo "<script> document.getElementById('block').innerHTML = 'Жалоба принята, " . $_GET['VOTE'] . "';
        </script>";
    }
}