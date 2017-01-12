<?php
  $authorid = $_GET['authorid'];
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

        @ $db = new mysqli('**************', '**************', '**************', '**************');
      
        if (mysqli_connect_errno()) {
           echo 'Error: Could not connect to database.  Please try again later.';
           exit;
        }
      
        $query = "select last_name, first_name from authors where author_id = $authorid";

        $result = $db->query($query);
        $row = $result->fetch_object();
        
        echo "<p><strong>".$row->first_name." ".$row->last_name.": </strong> ";
        
        $query = "select isbn, title from books where author_id = $authorid";
        $result = $db->query($query);
        $num_results = $result->num_rows;
        
        $s = "s";
        if($num_results == 1) {
          $s = "";
        }
        
        echo $num_results." book$s currently listed.</p>";

        for ($i=0; $i <$num_results; $i++) {
          $row = $result->fetch_object();
          echo "<p class='book'>";
          echo "<a href='thisBook.php?isbn=".$row->isbn."'>";
          echo htmlspecialchars(stripslashes($row->title));
          echo "</a>";
          echo "</p>";
        }
      
        $result->free();
        $db->close();

      ?>
    </div>
  </body>
</html>