<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->SetTitle("AJAX");
CJSCore::Init(array('ajax'));
$sidAjax = 'testAjax';

?>

<script>
    window.BXDEBUG = true;
    function DEMOLoad(){
        BX.hide(BX("block"));
        BX.show(BX("process"));
        BX.ajax.loadJSON(
            '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
            DEMOResponse
        );
    }
    function DEMOResponse (data){
        BX.debug('AJAX-DEMOResponse ', data);
        BX("block").innerHTML = data.RESULT;
        BX.show(BX("block"));
        BX.hide(BX("process"));

        BX.onCustomEvent(
            BX(BX("block")),
            'DEMOUpdate'
        );
    }

    BX.ready(function(){
        /*
        BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
           window.location.href = window.location.href;
        });
        */

        BX.bindDelegate(
            document.body, 'click', {className: 'css_ajax' },
            function(e){
                if(!e)
                    e = window.event;

                DEMOLoad();
                return BX.PreventDefault(e);
            }
        );

    });

</script>
<div class="group">
    <div id="block"></div >
    <div id="process"> </div >
</div>
<div class="css_ajax">Пожаловаться(ajax)</div>
<a onclick="location.replace(location.pathname + '?get_form=Y');">Пожаловаться(get)</a>

<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="news-date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<div class="news-detail">
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br />
	<?endforeach;?>
	</div>
</div>
