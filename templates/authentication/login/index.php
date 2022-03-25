
<p>
    <?php echo $this->Flash->render() ?>
</p>

<?php $googleAuthUrl = $this->Url->build(['_name' => 'auth_google_authentication'],['fullBase' => true]); ?>
<a href="<?= $googleAuthUrl ?>"> 
    Login with google 
</a> 