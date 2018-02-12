<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="/otakoyi/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Login</h1>
      <a href="/otakoyi/book" class="btn btn-primary">Go back</a>
      <form class="form-horizontal" action="" method="POST">
        <div class="form-group">
          <div class="col-sm-10">
            Moderator : admin
          </div>
          <div class="col-sm-10">
            Password : admin
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Moderator:</label>
          <div class="col-sm-10">
            <input value="<?= isset($inputs) ? $inputs['moderator'] : ""; ?>" type="text" class="form-control" placeholder="Enter moderator" name="moderator" >
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
          </div>
        </div>
        <?php
          if (isset($errors) && count($errors) > 0) {
            echo '<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    '.implode('<br/>', $errors).'
                  </div>';
          }
         ?>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
