<?php
    try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = '';
		$sessionId = $_POST['sessionId'];
		$readerId = $_POST['readerId'];
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

	    //Get all feeds details
		try{
	    	$query = "SELECT FeedID, Name, Description, Link FROM feeds";
			
	    	$stmt = $db->query($query);
			for ($i=0; $i<$stmt->rowCount(); $i++) {
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$subquery = "SELECT SubscriptionID FROM subscriptions WHERE FeedID = ".$row['FeedID']." AND ReaderID = ".$readerId;
				$substmt = $db->query($subquery);
				switch ($substmt->rowCount()) {
					case 0:
						$row['subscribed'] = false;
						break;
					case 1:
						$row['subscribed'] = true;
						break;
					default:
						$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
						$response->success = false;
						return;
				}
				$response->feeds[$i] = $row;
			}
	    } catch(Exception $e) {
			$response->errorMessage = $response->errorMessage.'Unable to run the query: '.$e->getMessage().' | ';
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