<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<h3><?=GetMessage("TITLE1")?></h3>
<ul>
 <?foreach ($arResult['ITEM'] as $news):?>
    <li>        <?=$news['NAME']?> - <?=$news['PRICE']?> - <?=$news['ARTNUMBER']?> - <?=$news['MATERIAL']?>    </li>
 <?endforeach;?>
</ul>
    <h3><?=GetMessage("TITLE2")?></h3>
<ul>
     <?foreach ($arResult['OTHER_USER'] as $news):?>
         <li>        <?=$news['NAME']?> - <?=$news['PRICE']?> - <?=$news['ARTNUMBER']?> - <?=$news['MATERIAL']?></li>
         <?$str = '';
         foreach ($news['USER'] as $user):
            $str .= $user . ',';
         endforeach;?>
         <?=GetMessage("USER")?><?=substr($str, 0, -1)?>

     <?endforeach;?>
</ul>
