
<h1> this is the home page </h1>

<?php $logoutUrl = $this->Url->build(['_name' => 'auth_logout'], ['fullBase'=>true]); ?>
<a href="<?= $logoutUrl ?>"> Logout </a>