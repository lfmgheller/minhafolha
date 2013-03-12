<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



?>

<!--<div>
    <?php if(isset($msg) && $msg != ''){ ?>
    <h3><?=$msg?></h3>
    <? } ?>
</div>-->

<div>
    <?php if(isset($msg) && $msg != ''){ ?>
    <!--<h3><?=$msg?></h3>-->
    <? } ?>
    
    <?php if(isset($this->db_session->userdata['sessionMsg']) && $this->db_session->userdata['sessionMsg'] != ''){ ?>
    <h3><?=$this->db_session->userdata['sessionMsg']?></h3>
    <?
    
    $this->db_session->unset_userdata('sessionMsg','');
    } ?>
</div>


<style>
    #reg_form div{
        margin-top:5px;
    }
</style>


<div >
    
    <h1>Login</h1>
    
    <form action="<?=base_url()?>index.php/authentication" method="post">
        
        <div>
            <div>Email</div>
            <div><input type="text" name="login_email" id="login_email" /></div>
        </div>
        
        <div>
            <div>Password</div>
            <div><input type="password" name="login_pwd" id="login_pwd" /></div>
        </div>
        
        <div>
            <input type="submit" value="Submit" />
        </div>
        
    </form>
        
    
    <a href="<?=  base_url()?>index.php/home/register">Register</a>
</div>

<div style="clear: both"></div>
