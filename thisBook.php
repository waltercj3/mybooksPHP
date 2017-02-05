<?php
  $isbn = $_GET['isbn'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>My Books</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/base.css">
  </head>
  <body>
  
    <h1>My Books</h1>
    
    <nav>
      <ul>
        <li><a href="mybooksHome.php" >Authors</a>
        </li><li><a href="mybooksBooks.php">Books</a>
        </li><li><a href="AddEdit.html">Add</a>
        </li>
      </ul>
    </nav>
    <div>
      <?php

        @ $db = new mysqli('#######', '#######', '#######', '#######');
      
        if (mysqli_connect_errno()) {
           echo 'Error: Could not connect to database.  Please try again later.';
           exit;
        }
      
        $query = "select * from books where isbn = $isbn";
        $bookresult = $db->query($query);
        $bookrow = $bookresult->fetch_object();
        
        $authorid = $bookrow->author_id;
        
        $query = "select last_name, first_name from authors where author_id = $authorid";
        $authorresult = $db->query($query);
        $authorrow = $authorresult->fetch_object();
        
        echo "<h3>".$bookrow->title."</h3>";
        echo "<p>By ".$authorrow->first_name." ".$authorrow->last_name."</p>";
        
        $orig_pub_date = $bookrow->orig_pub_date;
        if($orig_pub_date) {
          echo "<p>Originally published in $orig_pub_date</p>";
        }
        
        $curr_ed_date = $bookrow->curr_ed_date;
        if($curr_ed_date) {
          echo "<p>My edition published in $curr_ed_date</p>";
        }
      
        $bookresult->free();
        $authorresult->free();
        $db->close();

      ?>
    </div>
  </body>
</html>