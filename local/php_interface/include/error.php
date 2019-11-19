<?php

AddEventHandler("main", "OnEpilog", "_Check404Error");

function _Check404Error() {
    global $APPLICATION;
    if(defined("ERROR_404") && ERROR_404 == 'Y') {
        CEventLog::Add(array(
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "ERROR_404",
            "MODULE_ID" => "main",
            "ITEM_ID" => 123,
            "DESCRIPTION" => $APPLICATION->GetCurPage(),
        ));
    }
}
