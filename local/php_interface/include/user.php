<?
// файл /bitrix/php_interface/init.php
// регистрируем обработчик
AddEventHandler("main", "OnBeforeUserUpdate", Array("MyClass", "OnBeforeUserUpdateHandler"));

class MyClass
{
    // создаем обработчик события "OnBeforeUserUpdate"
    function OnBeforeUserUpdateHandler(&$arFields)
    {
        global $CACHE_MANAGER;
        $CACHE_MANAGER->ClearByTag("iblock_id_new");
    }
}
?>