<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



?>

<div>
    <?php if(isset($msg) && $msg != ''){ ?>
    <h3><?=$msg?></h3>
    <? } ?>
    
    <?php if(isset($this->db_session->userdata['sessionMsg']) && $this->db_session->userdata['sessionMsg'] != ''){ ?>
    <h3><?=$this->db_session->userdata['sessionMsg']?></h3>
    <?
    $this->db_session->unset_userdata('sessionMsg','');
    
    } ?>
</div>


<div><a href="<?=  base_url()?>">Back to Home</a></div>

<style>
    #reg_form div{
        margin-top:5px;
    }
</style>

<div style="float: left">
    <h1>Register</h1>

    <form id="reg_form" action="<?=base_url()?>index.php/authentication/register" method="post">
        <div>
            <div>Name</div>
            <div><input type="text" name="reg_name" id="reg_name" /> </div>
        </div>

        <div>
            <div>Email</div>
            <div><input type="text" name="reg_email" id="reg_email" /> </div>
        </div>

        <div>
            <div>Password</div>
            <div><input type="password" name="reg_pwd" id="reg_pwd" /> </div>
        </div>


        <div>
            <div>confirm Password</div>
            <div><input type="password" name="reg_cpwd" id="reg_cpwd" /> </div>
        </div>

        <div>
            <div><input type="submit" value="Submit" /></div>

        </div>


    </form>

</div>

<!--<div style="float: left;margin-left: 150px">
    
    <h1>Login</h1>
    
    <form action="<?=base_url()?>index.php/home/login" method="post">
        
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
        
</div>-->

<div style="clear: both"></div>
