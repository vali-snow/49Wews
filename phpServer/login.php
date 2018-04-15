<?php
    try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = '';
		$response->username = $_POST['username'];
		$response->password = $_POST['password'];
	    //Connect to the MySql Database
		try {
			$db = new PDO("mysql:host=127.0.0.1;dbname=49wews", "readerBee", "7");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'Unable to open the database: '.$e->getMessage().' | ';
			$response->success = false;
			return;
		}
	    //Check username and password
	    try{
	    	$query = "SELECT ReaderID FROM Readers WHERE Username = '".$response->username."' AND Password = '".$response->password."'";
	    	$stmt = $db->query($query);
			switch ($stmt->rowCount()) {
				case 0:
					$response->errorMessage = $response->errorMessage.'Invalid username or password! | ';
		    		$response->success = false;
		    		return;
				case 1:
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$response->readerid = $row["ReaderID"];
					break;
				default:
					$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
		    		$response->success = false;
		    		return;
			}
	    } catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'Unable to run the query: '.$e->getMessage().' | ';
			$response->success = false;
			return;
		}
		//Set SessionID
	    try{
	    	$sessionId = rand(100000000,999999999);
	        $stmt = $db->prepare("UPDATE Readers SET SessionID=? WHERE ReaderID=?");
	        $stmt->execute(array($sessionId, $response->readerid));
	        if($stmt->rowCount() == 1) {
	            setcookie("sessionId", $sessionId, time()+14400, "/");
	            setcookie("readerId", $response->readerid, time()+14400, "/");
	        } else {
	        	$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
	        	$response->success = false;
	        	return;
	        }
	    } catch(Exception $e) {
	        $response->errorMessage = $response->errorMessage.'Unable to run the update: '.$e->getMessage().' | ';
	        $response->success = false;
	        return;
	    }
    } catch (Exception $e){
    	$response->errorMessage = $response->errorMessage.'Other: '.$e->getMessage().' | ';
        $response->success = false;
    } finally {
		//Disconnect from the MySql Database
		$stmt = null;
	    $db = null;
	    //Pretify response
	    unset($response->username);
    	unset($response->password);
    	unset($response->readerid);
	    if ($response->errorMessage) {
	    	$response->errorMessage = 'Errors: '.substr($response->errorMessage, 0, -3);
	    } else {
	    	$response->errorMessage = 'No Errors!';
	    }
	    //Serialize and return response
		$json=json_encode($response);
		echo $json;
    }
?>