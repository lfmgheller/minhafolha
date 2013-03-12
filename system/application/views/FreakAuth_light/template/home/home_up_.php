<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<style>
    #reg_form div{
        margin-top:5px;
    }
</style>

<h1>Register</h1>

<form id="reg_form" action="<?=base_url()?>index.php/home/register" method="post">
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
        <div><input type="text" name="reg_pwd" id="reg_pwd" /> </div>
    </div>
    
    
    <div>
        <div>confirm Password</div>
        <div><input type="text" name="reg_cpwd" id="reg_cpwd" /> </div>
    </div>
    
    <div>
        <div><input type="submit" value="Submit" /></div>
            
    </div>
        
    
</form>