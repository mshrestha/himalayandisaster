<?php
session_start();
include "../../includes/adminIncludes.php";
include "../../system/functions.php" ;
include "../../system/config.php";
?>
<?php
if( isset($_POST["type"]) )
{
	$name = mysql_real_escape_string($_POST["username"]);
	$password = mysql_real_escape_string($_POST["password"]);
	$email = mysql_real_escape_string($_POST["email"]);
	$type = strtolower( mysql_real_escape_string($_POST["type"]) );
	$warehouseNo = (empty( mysql_real_escape_string($_POST["warehouse"]) ))? NULL: mysql_real_escape_string($_POST["warehouse"]) ;



	if($type == "register") {
                                        // New user hence, register them to the database
  	if(userNameExists(trim($name) ) ) {       // Firstly, check if the username already exists
  	 logMsg("username already exist",0);
  	}
  	elseif( strlen( trim($password) ) < 8 ){  // Check the password first
      logMsg("Password must be longer than 8 characters",0);
  	}
  	elseif(	!checkEmail($email) ) { // Now check the email
      logMsg("Invalid email supplied",0);
  	}
  	else
  	{
      $role = mysql_real_escape_string($_POST["userrole"]);
    	$hash = getPasswordHash($password);  //Generate hash
    	$qur = "Insert into " . $tableName['admin_login'] . " values (null,'$name','$hash','$email','$warehouseNo','$role')";
    	if( mysql_query($qur) )
    	{
    		logMsg("Sucessfully added new user",1);
    	}
    	else
    	{
    		logMsg( "Some Error Occured",0); //Samarpan, it's not good to give mysql_error in production, #securityIssues can give table name for hacks so we need to remove all with some funny message
     }
  }
}
  else{       //Login

  	if(userNameExists($name)){
    
  	$hash = getPasswordHash($password);

  	if(checkUsernameAndPass($name,$hash)){     
      logMsg("Logged in sucessfully",1);
      $_SESSION['name'] = $name;
      $qry = mysql_query("Select userrole from " . $tableName['admin_login'] . " where username='$name'");
      $ary = mysql_fetch_array($qry);
      $_SESSION['userrole'] = $ary[0];
    }
    else 
     logMsg("Invalid Username or password",0);


  }
  else 
    logMsg("User doesn't exist");

}
  redirectPage($_SERVER['HTTP_REFERER']);
}
elseif(isset($_GET["action"]) ){
  $action = mysql_real_escape_string($_GET["action"]);
  $userid = mysql_real_escape_string($_GET["id"]);



  if($action == "delete") {
    $qur = "Delete from ". $tableName["admin_login"]." where id = '$userid'"; 

    if( mysql_query($qur) )
      logMsg( "User sucessfully deleted!" , 1);
    else
      logMsg( "Error : " . mysql_error(), 0);
  }
  if($action == "logout"){
    logMsg("Logged out",1);
    session_destroy();
  }
  redirectPage($_SERVER['HTTP_REFERER']);
}


function userNameExists($username) {
  global $tableName;
  $query= mysql_query("select username from ".$tableName['admin_login']." where username='$username'");

  if(!$query)
    logMsg( "Some Error Occured :(" ,0);

  if (mysql_num_rows($query)>0)
	    return 1; 						// Username  exists
  else 
      return 0;
}
function checkUsernameAndPass($username,$password){
  global $tableName;
  $query= "select password from ".$tableName['admin_login']." where username='$username'";
  $query = mysql_query($query);
  
  if($query){
    $ary = mysql_fetch_array($query);
      if ($password == $ary[0])
	       return 1; 						// Username and password exists
      else 
         return 0;
  }
}
?>

