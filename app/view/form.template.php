<?php
  // print_r($captcha->inline());
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Complaints & Suggestions</title>
    <link rel="stylesheet" href="/otakoyi/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Add new Complaint Or Suggestion</h1>
      <a href="/otakoyi/book" class="btn btn-primary">Go back</a>
      <form class="" action="" method="post">
        <div class="form-group">
          <label for="name">Name</label>
          <input name="name" id="name" type="text" class="form-control" value="<?= isset($inputs) ? $inputs['name'] : ""; ?>" required>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input name="email" id="email" type="email" class="form-control" value="<?= isset($inputs) ? $inputs['email'] : ""; ?>" required>
        </div>

        <div class="form-group">
          <label for="website">Website</label>
          <input name="website" type="text" class="form-control" value="<?= isset($inputs) ? $inputs['website'] : ""; ?>" id="website">
        </div>
        <?php
          if (isset($captcha)) {
         ?>
            <div class="input-group">
              <img src="<?php echo $captcha->inline(); ?>" />
              <input name="captcha" type="text" class="form-control input-captcha" required>
            </div>
        <?php
          }
          if (isset($errors) && count($errors) > 0) {
            echo '<div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    '.implode('<br/>', $errors).'
                  </div>';
          }
         ?>
        <div class="input-group submit-btn">
          <input class="btn btn-primary form-control" type="submit" value="<?= $button; ?>">
        </div>
      </form>
    </div>

  </body>
</html>
