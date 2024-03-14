<?php 
setcookie('admin_id', '', time() - 1, '/');
setcookie('search_box', '', time() - 1, '/');
setcookie('search_user', '', time() - 1, '/');
setcookie('search_admin', '', time() - 1, '/');
setcookie('search_message', '', time() - 1, '/');

header('Location:../admin/login.php');
exit();


?>
