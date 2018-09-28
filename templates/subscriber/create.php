<!-- New Subscriber Form -->
<span id="response"></span>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 row-header">
    Add Subscriber
  </div>
</div>
<form id="create_subscriber">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 container-bg">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name." required>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name." required>
      </div>
    </row>
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address." required>
      </div>

      <div class="hidden-xs col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary pull-right btn-create">
          <i class="glyphicon glyphicon-plus"></i> INSERT SUBSCRIBER
        </button>
      </div>
      <div class="col-xs hidden-sm hidden-md hidden-lg hidden-xl">
        <button type="submit" id="submit" name="add-subscriber" id="add-subscriber" class="btn btn-primary pull-right btn-create">
          <i class="glyphicon glyphicon-plus"></i> INSERT
        </button>
      </div>

    </div>
  </div>
</form>
</div>
<!-- End New Subscriber Form -->
