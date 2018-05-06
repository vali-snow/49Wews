<?php
    try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = '';
		$sessionId = $_POST['sessionId'];
		$readerId = $_POST['readerId'];
		$FeedID = $_POST['FeedID'];
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
	    //Get Feed Content
		try{
	    	$query = "SELECT Link FROM feeds WHERE FeedID = ".$FeedID;
	    	$stmt = $db->query($query);
			switch ($stmt->rowCount()) {
				case 0:
					$response->errorMessage = $response->errorMessage.'Invalid FeedID! | ';
		    		$response->success = false;
		    		return;
				case 1:
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$response->link = $row['Link'];
					$response->items = array();
					$xmlDoc = new DOMDocument();
					$xmlDoc->load($response->link);
					$item_image = null;
						if (count($xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')) !=0){
							$item_image = $xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')->item(0)->getElementsByTagName('url')->item(0)->childNodes->item(0)->nodeValue;
						}
					foreach ($xmlDoc->getElementsByTagName('item') as $item) {
						$item_title = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
						$item_link = $item->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
						$item_desc = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
						array_push($response->items,array("title" => $item_title, "link" => $item_link, "description" => $item_desc, "image" => $item_image));
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