<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Complaints & Suggestions</title>
    <link rel="stylesheet" href="/otakoyi/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php
              if (Core\Auth::is_logged_in()) {
                echo '<li><a href="/otakoyi/logout">Logout</a></li>';
              }else{
                echo '<li><a href="/otakoyi/login">Login</a></li>';
              }
             ?>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <div class="container">
      <!-- <h1 class="text-center">Book of Complaints & Suggestions</h1> -->
      <div class="panel panel-default">
        <div class="panel-heading text-center">Book of Complaints & Suggestions</div>
          <table class="table" id="books-table">
            <thead>
              <tr>
                <th>#</th>
                <th><a class="order-btn" data-order="name" data-method="DESC" href="#">Name <span></span></a></th>
                <th><a class="order-btn" data-order="email" data-method="DESC" href="#">E-mail <span></span></a></th>
                <th>Website</th>
                <th><a class="order-btn active" data-order="created" data-method="DESC" href="#">Created <span>&darr;</span></a></th>
                <!-- &#8593; -->
              </tr>
            </thead>
            <?php
              $loggedin = Core\Auth::is_logged_in();
              foreach ($books as $key => $book) {
                echo "
                  <tr>
                    <td>{$book['id']}</td>
                    <td>{$book['name']}</td>
                    <td>{$book['email']}</td>
                    <td>{$book['website']}</td>
                    <td>{$book['created']}</td>
                    ".
                    ($loggedin ?
                    '<td><a class="btn btn-primary" href="/otakoyi/book/'.$book['id'].'">Update</a>
                      <a href="/otakoyi/book/'.$book['id'].'/delete" class="btn btn-danger" data-id="'.$book['id'].'">Delete</a></td>'
                      : '')
                    ."
                  </tr>
                ";
              }
            ?>
          </table>
          <div class="text-center">
            <ul class="pagination">
              <?php
                $var = ceil($count/$perpage);
                for ($i = 1; $i <= $var && $var>1; $i++) {
                  $active = $i == $page ? 'active' : '';
                  echo "<li class='page-btn $active' data-page='$i'><a href='/otakoyi/book&page=$i'>$i</a></li>";
                }
              ?>
            </ul>
          </div>
        </div>
        <a href="/otakoyi/book/new" class="btn btn-primary">Add new</a>

        </div>
      </div>
      <script src="/otakoyi/js/jquery-3.3.1.min.js"></script>
      <script src="/otakoyi/js/main.js"></script>
  </body>
</html>
