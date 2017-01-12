<!DOCTYPE html>
<html>
  <head>
    <title>Add/Edit Results</title>
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
    
    <h3>Add/Edit Results</h3>
    
    <?php
      // create short variable names
      $isbn=trim($_POST['isbn']);
      $title=trim($_POST['title']);
      $authorLast=trim($_POST['authorLast']);
      $authorFirst=trim($_POST['authorFirst']);
      $class=$_POST['class'];
      $rating=$_POST['rating'];
      $orig_pub_date=$_POST['orig_pub_date'];
      $curr_ed_date=$_POST['curr_ed_date'];
    
      if (!$isbn) {
         echo "An ISBN is required.<br />"
              ."Please go back and try again.";
         exit;
      }
      
      // echo "<p>isbn: $isbn<br />"
      //     ."title: $title<br />"
      //     ."authorLast: $authorLast<br />"
      //     ."authorFirst: $authorFirst<br />"
      //     ."class: $class<br />"
      //     ."rating: $rating<br />"
      //     ."orig_pub_date: $orig_pub_date<br />"
      //     ."curr_ed_date: $curr_ed_date<br />"
      //     ."</p>";
      
      $isbn = strtoupper($isbn);
      $isbn = preg_replace('/[^0-9,X]+/', '', $isbn);
      $isbnLength = strlen($isbn);
      // echo "<p>Length of isbn: $isbnLength</p>";
      if ($isbnLength < 10) {
        $isbn = str_pad($isbn, 10, "0", STR_PAD_LEFT);
      } elseif ($isbnLength != 10 && $isbnLength != 13) {
        echo "<p>An ISBN should have 10 or 13 digits.<br />"
              ."Please go back and try again.</p>";
        exit;
      }
      
      if (!get_magic_quotes_gpc()) {
        $title = addslashes($title);
        $authorLast = addslashes($authorLast);
        $authorFirst = addslashes($authorFirst);
      }
      
      if ($class != 1 && $class != 2 && $class != 3 && $class != 4 && $class != 5) {
        $class = NULL;
      }
      
      if ($rating === 0 || $rating === 1 || $rating === 2 || $rating === 3 || $rating === 4) {
        $rating = $rating + 1;
      } else {
        $rating = NULL;
      }
      
      if ($orig_pub_date < 1888 || $orig_pub_date > 2088) {
        $orig_pub_date = NULL;
      }
      
      if ($curr_ed_date < 1888 || $curr_ed_date > 2088) {
        $curr_ed_date = NULL;
      }
      
      echo "<p>isbn: $isbn<br />"
          ."title: $title<br />"
          ."authorLast: $authorLast<br />"
          ."authorFirst: $authorFirst<br />"
          ."class: $class<br />"
          ."rating: $rating<br />"
          ."orig_pub_date: $orig_pub_date<br />"
          ."curr_ed_date: $curr_ed_date<br />"
          ."</p>";
    
      @ $db = new mysqli('**************', '**************', '**************', '**************');
    
      if (mysqli_connect_errno()) {
        echo "Error: Could not connect to database.  Please try again later.";
        exit;
      }
      
      //code needed for the situation where the author is not already in the database
      
      $last_name = stripslashes($authorLast);
      $query = "SELECT author_id FROM authors WHERE last_name LIKE '".$last_name."'";
      //echo "$query";
      $result = $db->query($query);

      if($result) {
        $row = $result->fetch_object();
        $author_id = $row->author_id;
      } else {
        echo "<p>This author is not listed.<br />"
              ."Please go back and try again.</p>";
        exit;
      }
      
      $query = "insert into books values(?, ?, ?, ?, ?, ?, ?)";
      $stmt = $db->prepare($query);
      $stmt->bind_param("sssiiii", $isbn, $title, $author_id, $class_id, $book_rate_id, $orig_pub_date, $curr_ed_date);
      $stmt->execute();
      $result = $stmt->affected_rows;
      //echo "affected rows: $result<br />";
    
      if ($result > 0) {
          echo  $result." book inserted into database.";
      } else {
      	  echo "An error has occurred.  The item was not added.";
      }
    
      $db->close();
    
    ?>
  </body>
</html>
