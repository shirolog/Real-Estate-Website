<?php 
require('./connect.php');


setcookie('user_id', '', time() - 1, '/');
setcookie('filter_search', '', time() - 1, '/');
setcookie('bhk', '', time() - 1, '/');
setcookie('status', '', time() - 1, '/');
setcookie('min', '', time() - 1, '/');
setcookie('max', '', time() - 1, '/');
setcookie('offer', '', time() - 1, '/');
setcookie('address', '', time() - 1, '/');
setcookie('type', '', time() - 1, '/');
setcookie('furnished', '', time() - 1, '/');
header('Location:../../login.php');
exit();

?>

