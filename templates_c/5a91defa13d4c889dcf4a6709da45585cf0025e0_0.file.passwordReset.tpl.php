<?php
/* Smarty version 3.1.36, created on 2020-06-16 12:18:10
  from '/home/rene/PhpstormProjects/MVC/templates/dist/passwordReset.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_5ee89c6291c9a4_82475072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5a91defa13d4c889dcf4a6709da45585cf0025e0' => 
    array (
      0 => '/home/rene/PhpstormProjects/MVC/templates/dist/passwordReset.tpl',
      1 => 1592302340,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ee89c6291c9a4_82475072 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17548093005ee89c62912a30_87050320', "baselayout");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3583496775ee89c62915ca1_87549481', "body");
$_smarty_tpl->inheritance->endChild($_smarty_tpl, "basic.tpl");
}
/* {block "baselayout"} */
class Block_17548093005ee89c62912a30_87050320 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'baselayout' => 
  array (
    0 => 'Block_17548093005ee89c62912a30_87050320',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block "baselayout"} */
/* {block "body"} */
class Block_3583496775ee89c62915ca1_87549481 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_3583496775ee89c62915ca1_87549481',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <body>
    <section class="page-section" id="login">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Login Area</h2>
                <h3 class="section-subheading text-muted">I am not a robot. I am not a monkey. I will not dance, even if
                    the beat is funky.</h3>
            </div>
            <form novalidate="novalidate" method="post" id="contactForm" name="sentMessage">
                <?php if ((isset($_smarty_tpl->tpl_vars['loginMessage']->value))) {?>
                    <?php echo $_smarty_tpl->tpl_vars['loginMessage']->value;?>

                <?php }?>
                <div class="row align-items-stretch mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" name="page" value="backend">
                            <input class="form-control" id="email" type="email" name="email"
                                   placeholder="Your E-Mail *" required="required"
                                   data-validation-required-message="Please enter your email address."/>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div id="resetpassword">
                        <button class="btn btn-primary btn-xl text-uppercase" id="resetpassword"
                                name="resetpassword" type="submit" value="resetpassword">
                            Send Reset Mail
                    </div>
                </div>
            </form>

            <div class="text-center">

                <a href="/Index.php?cl=login&page=login&admin=true" class="list-group-item list-group-item-action">Return to login</a>

            </div>
        </div>
        </div>

        </div>
    </section>
    </body>
<?php
}
}
/* {/block "body"} */
}
