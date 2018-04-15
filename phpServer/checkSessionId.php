<?php
    try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = "Errors:";
		$response->readerid = $_POST['readerId'];
	    //Connect to the MySql Database
		try {
			$db = new PDO("mysql:host=127.0.0.1;dbname=49wews", "readerBee", "7");
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'\nUnable to open the database: '.$e->getMessage();
			$response->success = false;
			return;
		}
	    //Check if SessionId is correct
	    try{
	    	$query = "SELECT SessionID FROM Readers WHERE ReaderID = ".$response->readerid;
	    	unset($response->readerid);
	    	$stmt = $db->query($query);
	    	if ($stmt->rowCount() == 1) {
	    		$row = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($row["SessionID"] != $_COOKIE['sessionId']) {
					$response->errorMessage = $response->errorMessage.'\nInvalid SessionID!';
					$response->success = false;
				}
	    	} else {
	    		$response->errorMessage = $response->errorMessage.'\nDatabase inconsistency!';
	    		$response->success = false;
	    		return;
	    	}
	    } catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'\nUnable to run the query: '.$e->getMessage();
			$response->success = false;
			return;
		}
    } catch (Exception $e){
    	$response->errorMessage = $response->errorMessage.'\nOther: '.$e->getMessage();
        $response->success = false;
    } finally {
		//Disconnect from the MySql Database
		$stmt = null;
	    $db = null;
	    //Serialize and return response
		$json=json_encode($response);
		echo $json;
    }
?>