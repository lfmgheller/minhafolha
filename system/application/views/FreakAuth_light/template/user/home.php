<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div>
    <div style="float: left">
        <?php if(isset($msg) && $msg != '') { ?>
        <h3><?=$msg?></h3>
        <? } ?>
        
        
        <?php if(isset($this->db_session->userdata['sessionMsg']) && $this->db_session->userdata['sessionMsg'] != ''){ ?>
    <h3><?=$this->db_session->userdata['sessionMsg']?></h3>
    <?
    $this->db_session->unset_userdata('sessionMsg','');
    
    } ?>
    </div>
    
    
    
    <div style="float: right">
        <a href="<?=  base_url()?>index.php/authentication/logout">Logout</a>
    </div>
    
    <div style="clear: both"></div>
</div>

<div>
    <h1>Password Reset</h1>
    
    <form action="<?=  base_url()?>index.php/user/reset_password" method="post">
        <div>
            <div>Old Password</div>
            <div><input type="password" name="pwdr_opwd" id="pwdr_opwd" /></div>
        </div>
        
        <div>
            <div>New Password</div>
            <div><input type="password" name="pwdr_npwd" id="pwdr_npwd" /></div>
        </div>
        
        <div>
            <div>Confirm Password</div>
            <div><input type="password" name="pwdr_cpwd" id="pwdr_cpwd" /></div>
        </div>
        
        <div>
            <input type="submit" value="Submit" />
        </div>
    </form>
</div>

