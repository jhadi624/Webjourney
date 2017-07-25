<?

include_once 'dbconfig';

function sec_session_start() {
	$session_name = 'sec_session_id';
	$secure = SECURE;
	$httponly = true; //stop javascript from accessing session id.

	if (ini_set('session.use_only_cookies', 1) === FALSE){
	
		header("Location:.../error.php?err=Could not initiate a safe session (ini_set)");
		exit();
		
	}
	//get current cookies param
	$cookieParams = session_get_cookie_params();
	session_get_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
	
	session_name($session_name);
	session_start(); // start php session
	session_regenerate_id(); //regenerate the session and delete the old one


}

function login($email, $password, $mysqli) {
	//prepare the statement
	
	if ($stmt = $mysqli->prepare("SELECT user_id, username, password, salt FROM user WHERE email = ? LIMIT 1")){
	$stmt->bind_param('s', $email); //set string as $email
	$stmt->execute();
	$stmt->store_result();
	
	$stmt->bind_result($user_id, $username, $password, $salt);
	$stmt->fetch();
	
	$password = hash('sha512', $password . $salt);
	
	//if ($stmt->num_rows == 1)
	// if user exist, check ban account
	
	}
	
}

function checkbrute($user_id, $mysqli) {
	$now = time();	
	$valid_attemps = $now - (2 *60 * 60);
	
	if ($stmt = $mysqli->prepare("SELECT time FROM login_attemps WHERE user_id = ? AND time > '$valid_attemps'")) {
	
	$stmt->bind_param('i', $user_id);
	
	$stmt->execute();
	$stmt->store_result();
	
	
		if($stmt->num_rows > 5) {
			return true;
			} else {return false;}
	}else {
		header("Location:../error.php?err=Database error: Cannot Prepare Statement");
		exit();
	}
}
	
function login_check($mysqli) {
 	if (isset($_SESSION['user_id'],$_SESSION['username'], $_SESSION['login_string'])) {
	
	$user_id = $_SESSION['userid'];
	$login_string = $_SESSION['login_string'];
	$username = $_SESSION['username'];
	
	$user_browser = $_SERVER['HTTP_USER_AGENT'];
	
	
			
	}
	
}






?>