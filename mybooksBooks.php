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
        </li><li class="current"><a href="#">Books</a>
        </li><li><a href="AddEdit.html">Add</a>
        </li>
      </ul>
    </nav>
    <div>
      <?php
      
        @ $db = new mysqli('**************', '**************', '**************', '**************');
      
        if (mysqli_connect_errno()) {
           echo '<h3>Error: Could not connect to database.  Please try again later.</h3>';
           exit;
        }

        $query = "select books.isbn, books.title, authors.last_name, authors.first_name
                  from books, authors
                  where books.author_id = authors.author_id
                  order by title";

        $result = $db->query($query);
      
        $num_results = $result->num_rows;
      
        echo "<p><strong>Books:</strong> ".$num_results." currently listed.</p>";

        for ($i=0; $i <$num_results; $i++) {
          $row = $result->fetch_object();
          echo "<p class='book'>";
          echo "<a href='thisBook.php?isbn=".$row->isbn."'>";
          echo htmlspecialchars(stripslashes($row->title));
          echo "</a>";
          echo " by ".htmlspecialchars(stripslashes($row->first_name))." ".htmlspecialchars(stripslashes($row->last_name));
          echo "</p>";
        }
      
        $result->free();
        $db->close();

      ?>
    </div>
  </body>
</html>