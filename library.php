<?php
error_reporting(E_ALL);

/*
 Github is an extension for pulling data using the github API.
 It also handles the VICTR database and manages the data needed for init.
*/
class Github {
  // Class variables
  public $details;

  function __construct()
  {
        // Need to first start by storing / updating the table
        $this->fillTable();

        // This is a hacked up way of doing this. If I was using laravel or symfony,
        // it would be created by using routing syntax for functions
        if(isset($_POST['ajax']) && $_POST['ajax'] == true){
          switch($_POST['method']){
            case "details":
              $this->details = $this->getDetails($_POST['rid']);
              break;
            default:
              // Nothing needed
              break;
          }
        }
  }

  # fillTable starts the application by updating or inserting data into the table
  # based the PHP language and sorted by the star count
  private function fillTable(){
    $db = $this->dbConnect();
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL       => 'https://api.github.com/search/repositories?q=+language:php&sort=stars&order=desc',
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_USERAGENT => 'trickell'
    ));
    $res = curl_exec($curl);
    $obj = json_decode($res);

    // Store data in table || update information
    $sql = "INSERT INTO github (RepositoryID, Name, URL, CreatedDate, LastPushDate, Description, Stars) values ";
    $values = [];
    foreach($obj->items as $row){
        // Build of values
        $values[] = "('$row->id','$row->name','$row->html_url','$row->created_at','$row->pushed_at','$row->description','$row->stargazers_count')";
    }

    // Insert OR update values
    $sql.= implode(',', $values);
    $sql.= ' ON DUPLICATE KEY UPDATE Name=VALUES(Name), URL=VALUES(URL), CreatedDate=VALUES(CreatedDate),';
    $sql.= ' LastPushDate=VALUES(LastPushDate), Description=VALUES(Description), Stars=VALUES(Stars)';

    $q = $db->prepare($sql);
    $q->execute();
  }

  public function getRowsByStar($count=null){
    if($count == null) $count = 30;

    // Connect to DB
    $db = $this->dbConnect();

    // Gather $count rows by star count
    $q = $db->query("SELECT * FROM github order by Stars desc LIMIT $count");
    return $q->fetchAll(PDO::FETCH_OBJ);
  }

  # Fetch details of repository
  public function getDetails($rid){
    // Connect to DB
    $db = $this->dbConnect();

    // Gather repository details
    $q = $db->query("SELECT * FROM github where RepositoryID=$rid");
    return $q->fetchAll(PDO::FETCH_OBJ);
  }

  # This is just a simplified way of connecting to the DB for querying.
  private function dbConnect(){
    $dbname = 'victr';
    $host = 'mysql:host=localhost;dbname='.$dbname;
    $user = 'victr';
    $pass = 'victr';

    try {
      $con = new PDO($host, $user, $pass);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo $e->getMessage();
    }

    return $con;
  }

}

$git = new Github;
?>
