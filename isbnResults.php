<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
    
    $isbn = $_GET['isbn'];
  
    @ $db = new mysqli('#######', '#######', '#######', '#######');
        
    if (mysqli_connect_errno()) {
       $error = 'Error: Could not connect to database.  Please try again later.';
       echo '{"error": "'.$error.'"}';
       exit;
    }
  
    $query = "select * from books where isbn = $isbn";
    $bookresult = $db->query($query);
    if (!is_object($bookresult)) {
       $error = "<p>No results found for ISBN ".$isbn
                  .". Complete entry to add book.</p>";
       echo '{"error": "'.$error.'"}';
       exit;
    }
    $bookrow = $bookresult->fetch_object();
    
    $authorid = $bookrow->author_id;
    
    $query = "select last_name, first_name from authors where author_id = $authorid";
    $authorresult = $db->query($query);
    $authorrow = $authorresult->fetch_object();
    
    $title = stripslashes($bookrow->title);
    $authorLast = stripslashes($authorrow->last_name);
    $authorFirst = stripslashes($authorrow->first_name);
    $class_id = $bookrow->class_id;
    $book_rate_id = $bookrow->book_rate_id;
    if ($book_rate_id) {
      $book_rate_id = $book_rate_id -1;
    }
    $orig_pub_date = $bookrow->orig_pub_date;
    $curr_ed_date = $bookrow->curr_ed_date;
  
    $bookresult->free();
    $authorresult->free();
    $db->close();

  echo '{"data": {"title": "'.$title
            .'", "authorLast": "'.$authorLast
            .'", "authorFirst": "'.$authorFirst
            .'", "class_id": "'.$class_id
            .'", "book_rate_id": "'.$book_rate_id
            .'", "orig_pub_date": "'.$orig_pub_date
            .'", "curr_ed_date": "'.$curr_ed_date
            .'"}}';
?>