<?php

$user = new User();

$user->logout();

echo '<div class="outer-wrapper">
  <div class="inner-wrapper">
    <div class="container">
      <div class="row">
        <div class="alert alert-success" role="alert">
          You have successfully logged out of your account.
        </div>
      </div>
    </div>
  </div>
</div>';

?>
