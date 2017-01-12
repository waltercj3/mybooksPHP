<!DOCTYPE html>
<html>
  <head>
    <title>My Books Home</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/base.css">
  </head>
  <body>
  
    <h1>My Books</h1>
    
    <nav>
      <ul>
        <li class="current"><a href="#" >Authors</a>
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
      
        $query = "select * from authors order by last_name";
        $result = $db->query($query);
      
        $num_results = $result->num_rows;
      
        echo "<p><strong>Authors:</strong> ".$num_results." currently listed.</p>";

        for ($i=0; $i <$num_results; $i++) {
          $row = $result->fetch_object();
          echo "<p class='author'>";
          echo "<a href='thisAuthor.php?authorid=".$row->author_id."'>";
          echo htmlspecialchars(stripslashes($row->first_name)." ".stripslashes($row->last_name));
          echo "</a>";
          echo "</p>";
        }
      
        $result->free();
        $db->close();

      ?>
    </div>
  </body>
</html>