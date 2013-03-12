


<h2><?=$action?></h2>
<p>&nbsp;</p>
<?=form_open_multipart('admin/tips/show/')?>
<?php /*?><?=form_open('admin/'.$controller.'/addImg')?><?php */?>

<?php
//if no records in DB don't display the result table
if (isset($reg)) 
  { $count=0;?> 
<table border="0" width="400px" style="border: 1px #AAA solid" cellpadding="0" cellspacing="0">
    <tr style="height: 40px">
        <td width="150px" style="background-color: burlywood;border-bottom: 1px #AAA solid">Tips Title</td>
        <td style="border-bottom: 1px #AAA solid;padding-left: 5px"><?=$reg['tips_title'];?></td>
    </tr>

    <tr>
        <td width="150px" style="background-color: burlywood;height: 40px">Tips Description</td>
        <td style="padding-left: 5px"><?=$reg['tips_dec'];?></td>
    </tr>
</table>
<?php } 
else { ?>
<table>
<tr>
<td>No record to display</td>
</tr>
</table>
<? } ?>
<?if(!isset($img)){?>

<?}?>
<input type="button" name="Back" value="Back" class="submit" onclick="location.href ='<?=site_url('admin/'.$controller.'/')?>'" />