<?php
    try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = '';
		$sessionId = $_POST['sessionId'];
		$readerId = $_POST['readerId'];
		$feedId = $_POST['feedId'];
		$feedName = $_POST['feedName'];
		$feedDescription = $_POST['feedDescription'];
		$feedLink = $_POST['feedLink'];
	    //Connect to the MySql Database
		try {
			$db = new PDO("mysql:host=127.0.0.1;dbname=49wews", "readerBee", "7");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'Unable to open the database: '.$e->getMessage().' | ';
			$response->success = false;
			return;
		}
	    //Check if sessionId matches
	    try{
	    	$query = "SELECT SessionID FROM Readers WHERE ReaderID = ".$readerId;
	    	$stmt = $db->query($query);
			switch ($stmt->rowCount()) {
				case 0:
					$response->errorMessage = $response->errorMessage.'Invalid ReaderID! | ';
		    		$response->success = false;
		    		return;
				case 1:
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($sessionId != $row["SessionID"]) {
					    $response->errorMessage = $response->errorMessage.'Invalid SessionID! | ';
		    			$response->success = false;
		    			return;
					}
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
		if ($feedId == "undefined"){
			//INSERT NEW FEED
			try{
				$stmt = $db->prepare("INSERT INTO feeds (Name,Description,Link) VALUES (?,?,?)");
				$stmt->execute(array($feedName, $feedDescription, $feedLink));
				if($stmt->rowCount() != 1) {
					$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
					$response->success = false;
					return;
				}
			} catch(Exception $e) {
				$response->errorMessage = $response->errorMessage.'Unable to run the query: '.$e->getMessage().' | ';
				$response->success = false;
				return;
			}
		}else{
			//UPDATE FEED
			try{
				$stmt = $db->prepare("UPDATE feeds SET Name = ?, Description = ?, Link = ? WHERE FeedID = ?");
				$stmt->execute(array($feedName, $feedDescription, $feedLink, $feedId));
				if($stmt->rowCount() != 1) {
					$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
					$response->success = false;
					return;
				}
			} catch(Exception $e) {
				$response->errorMessage = $response->errorMessage.'Unable to run the query: '.$e->getMessage().' | ';
				$response->success = false;
				return;
			}
		}
    } catch (Exception $e){
    	$response->errorMessage = $response->errorMessage.'Other: '.$e->getMessage().' | ';
        $response->success = false;
    } finally {
		//Disconnect from the MySql Database
		$stmt = null;
	    $db = null;
	    //Pretify response
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