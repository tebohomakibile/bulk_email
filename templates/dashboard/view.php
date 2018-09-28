<?php

  $dashboard = new Dashboard();

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <a href="./Email/View" class="btn btn-primary btn-lg" role="button">
                <h1><?php echo $dashboard->sentMail(); ?></h1>
                <span class="glyphicon glyphicon-envelope stat"></span> <br/>SENT EMAILS
              </a>

              <?php

                $dashboard->setSqlWhere('Delivered');

              ?>

              <a href="Email/View" class="btn btn-success btn-lg" role="button">
                <h1><?php echo $dashboard->sentMail(); ?></h1>
                <span class="glyphicon glyphicon-envelope stat"></span> <br/>DELIVERED EMAILS
              </a>

              <?php

                $dashboard->setSqlWhere('Failed');

              ?>

              <a href="<?php echo HOST . PATH; ?>Email/View" class="btn btn-danger btn-lg" role="button">
                <h1><?php echo $dashboard->sentMail(); ?></h1>
                <span class="glyphicon glyphicon-envelope stat"></span> <br/>FAILED EMAILS
              </a>
              <a href="<?php echo HOST . PATH; ?>Subscriber/View" class="btn btn-info btn-lg" role="button">
                <h1><?php echo $dashboard->getSubscribers(); ?></h1>
                <span class="glyphicon glyphicon-user stat"></span> <br/>SUBSCRIBERS
              </a>
              <a href="<?php echo HOST . PATH; ?>Lists/View" class="btn btn-warning btn-lg" role="button">
                <h1><?php echo $dashboard->getMailingLists(); ?></h1>
                <span class="glyphicon glyphicon-list stat"></span> <br/>MAILING LISTS
              </a>
              <a href="#" id="get_config" class="btn btn-primary btn-lg config" role="button">
                <h1>CONFIG</h1>
                <span class="glyphicon glyphicon-cog stat"></span> <br/>SETTINGS
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="config_container">
  </div>

</div>

<script type="text/javascript">

  $("#get_config").click(function(){
    $.ajax({
      type: "GET",
      url: "<?php echo HOST . PATH; ?>templates/dashboard/config.php",
      dataType: "html",
      success: function(response){
          $("#config_container").html(response);
      }
    });
    $("#edit_container").html('');
  });

</script>
