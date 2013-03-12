<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div>
    <?php if (isset($msg) && $msg != ''){ ?>
    <h3><?=$msg?></h3>
    <a href="<?=  base_url()?>">Back to Home</a>
    <? exit; } ?>
</div>

<h1>Confirm Registration</h1>

<p>Check your email. We have sent you a confirmation code in your email. Enter that code Here and be confirmed.</p>

<a href="<?=  base_url()?>">Back to Home</a>

<form id="conf_form" action="<?=base_url()?>index.php/authentication/confirmtoken" method="post">

    <div>
        <div>Confirmation Token</div>
        <div><input type="text" name="conf_token" id="conf_token" /></div>
    </div>
    
    <div>
        <input type="submit" value="Submit" />
    </div>
    
</form>

