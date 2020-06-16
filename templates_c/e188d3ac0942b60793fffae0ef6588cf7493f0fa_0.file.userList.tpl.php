<?php
/* Smarty version 3.1.36, created on 2020-06-15 14:48:08
  from '/home/rene/PhpstormProjects/MVC/templates/dist/userList.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.36',
  'unifunc' => 'content_5ee76e08d741f1_89010561',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e188d3ac0942b60793fffae0ef6588cf7493f0fa' => 
    array (
      0 => '/home/rene/PhpstormProjects/MVC/templates/dist/userList.tpl',
      1 => 1592225285,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ee76e08d741f1_89010561 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
<html lang="">

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7041874565ee76e08d3d6b4_95540582', "subtitel_h1");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15740261455ee76e08d40985_20953988', "titel");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15549102635ee76e08d449e8_33205538', "titel_button");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5582628285ee76e08d483d6_03971699', "titel_button_href");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_71461735ee76e08d4bce8_83338829', "body");
?>

</html><?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, "basic.tpl");
}
/* {block "subtitel_h1"} */
class Block_7041874565ee76e08d3d6b4_95540582 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'subtitel_h1' => 
  array (
    0 => 'Block_7041874565ee76e08d3d6b4_95540582',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php
}
}
/* {/block "subtitel_h1"} */
/* {block "titel"} */
class Block_15740261455ee76e08d40985_20953988 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'titel' => 
  array (
    0 => 'Block_15740261455ee76e08d40985_20953988',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Welcome to the Backstagearea<?php
}
}
/* {/block "titel"} */
/* {block "titel_button"} */
class Block_15549102635ee76e08d449e8_33205538 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'titel_button' => 
  array (
    0 => 'Block_15549102635ee76e08d449e8_33205538',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Back to home<?php
}
}
/* {/block "titel_button"} */
/* {block "titel_button_href"} */
class Block_5582628285ee76e08d483d6_03971699 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'titel_button_href' => 
  array (
    0 => 'Block_5582628285ee76e08d483d6_03971699',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
"http://localhost:8080/Index.php?cl=home"<?php
}
}
/* {/block "titel_button_href"} */
/* {block "body"} */
class Block_71461735ee76e08d4bce8_83338829 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'body' => 
  array (
    0 => 'Block_71461735ee76e08d4bce8_83338829',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <body>
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Userlist</h2>
                <h3 class="section-subheading text-muted">Manage our User</h3>

                <form id="deleteUpdateForm" name="deleteUpdateform" action="" method="post">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                            <th scope="col"></th>
                            <th scope="col">
                                <button type="button" class="btn btn-primary btn-sm" id="create" data-toggle="modal"
                                        data-target="#model">
                                    Create new User
                                </button>
                            </th>
                        </tr>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['userList']->value, 'user', false, NULL, 'aussen', array (
));
$_smarty_tpl->tpl_vars['user']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->do_else = false;
?>
                        </thead>
                        <tr>
                            <th scope="row" id=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUsername();?>
><?php echo $_smarty_tpl->tpl_vars['user']->value->getUsername();?>
</th>
                            <td><?php echo $_smarty_tpl->tpl_vars['user']->value->getUserRole();?>

                            <td>
                            <td>
                                <button class="btn btn-primary btn-sm text-uppercase" id="delete"
                                        data-title=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUserName();?>
 name="delete"
                                        type="submit" value=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUserName();?>
>Delete
                                </button>
                            </td>
                            <th scope="col"><a class="btn btn-primary btn-sm text-uppercase"
                                               data-title=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUserName();?>
 id=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUserName();?>

                                               name="edit"
                                               href="/Index.php?cl=user&page=detail&id=<?php echo $_smarty_tpl->tpl_vars['user']->value->getUserId();?>
&admin=true"
                                               type="submit">Edit
                                </a></th>
                        </tr
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </tbody>
                    </table>
            </div>
            </form>
        </div>
        <div class="text-center">
            <a href="/Index.php?cl=dashboard&admin=true" class="list-group-item list-group-item-action">Return to Dashboard</a>
            <form id="logout" name="logout" action="" method="post">
                <button class="btn btn-primary btn-lg text-uppercase" id="logout" name="logout" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </section>
    <div class="modal fade" id="model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="text-center">
                    <h2 class="text-uppercase">New User</h2>
                    <p class="item-intro text-muted"></p>
                    <form id="usercreation" name="usercreation" action="" method="post">
                        <div class="text-center">
                            <input type="text" name="newusername" id="newusername" placeholder="username"/>
                            <input type="password" name="newuserpassword" id="newuserpassword" placeholder="password"/>
                            <br>
                            <br>

                            <select class="selectpicker" id="newuserrole" name="newuserrole">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="root">Root</option>
                            </select>
                            <br>
                            <br>
                        </div>
                            <button class="btn btn-primary btn-lg text-uppercase" id="save" name="save" type="submit">
                                Create
                            </button>

                    </form>
                    <p>
                        <button class="btn btn-primary btn-sm" data-dismiss="modal" type="button"><i
                                    class="fas fa-times mr-1"></i>Discard
                        </button>
                </div>
            </div>
        </div>
    </div>


    </body>
<?php
}
}
/* {/block "body"} */
}
