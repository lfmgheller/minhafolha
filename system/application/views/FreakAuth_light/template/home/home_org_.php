<?=$fal_login?>
<?php if($host!="") { ?>
                <div style="width: 256px;border: 1px solid #848484;height: 236px;border-bottom: 0px;border-top: 0px;padding: 5px">
                     <div style="width: 185px;float: left;font-size: 12px;float: left">Wellcome,&nbsp;<?=$name?>&nbsp;</div>
                     <div style="float: left;width: 70px" align="right"><a href="<?=base_url()?>index.php/auth/logout.html" style="font-size: 14px;font-weight: bold">Logout</a></div>
                     <div style="font-size: 12px;">
                         <div style="padding-top: 32px">&raquo;&nbsp;<a href="<?=base_url()?>index.php/profile/">My Profile</a></div>                          
                     </div>
                </div>
                <?php } ?>