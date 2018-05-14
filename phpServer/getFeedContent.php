<?php	
	try {
		//Initialize Response
		$response = new StdClass();
		$response->success = true;
		$response->errorMessage = '';
		$sessionId = $_POST['sessionId'];
		$readerId = $_POST['readerId'];
		$FeedID = $_POST['FeedID'];
		$dateFilter = $_POST['dateFilter'];
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
			if ($FeedID == "ALL"){
				$query = "SELECT Link FROM feeds f JOIN subscriptions s ON f.FeedID=s.FeedID WHERE readerID=".$readerId;
				$stmt = $db->query($query);
				$response->items = array();
				for ($i = 0; $i < $stmt->rowCount(); $i++) {
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$link = $row['Link'];
					$xmlDoc = new DOMDocument();
					$xmlDoc->load($link);
					$item_image = null;
						if (count($xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')) !=0){
							$item_image = $xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')->item(0)->getElementsByTagName('url')->item(0)->childNodes->item(0)->nodeValue;
						}
					foreach ($xmlDoc->getElementsByTagName('item') as $item) {
						$item_title = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
						$item_link = $item->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
						$item_desc = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
						$item_date = $item->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
						$dateCheck = true;
						switch ($dateFilter) {
							case "7":
								if (strtotime("now")-strtotime($item_date)>604800) {$dateCheck = false;}
								break;
							case "2":
								if (strtotime("now")-strtotime($item_date)>172800) {$dateCheck = false;}
								break;
							case "1":
								if (strtotime("now")-strtotime($item_date)>86400) {$dateCheck = false;}
								break;
						}
						if ($dateCheck == true) {
							array_push($response->items,array("title" => $item_title, "link" => $item_link, "description" => $item_desc, "image" => $item_image, "date" =>$item_date));
						}
					}
				}
				if (count($response->items)>1){
					foreach ($response->items as $key => $row) {
						$date[$key] = strtotime($row['date']);
					}
					array_multisort($date, SORT_DESC, $response->items);
				}
			}else{
				$query = "SELECT Link FROM feeds WHERE FeedID = ".$FeedID;
				$stmt = $db->query($query);
				switch ($stmt->rowCount()) {
					case 0:
						$response->errorMessage = $response->errorMessage.'Invalid FeedID! | ';
						$response->success = false;
						$response->items = array();
						return;
					case 1:
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						$link = $row['Link'];
						$response->items = array();
						$xmlDoc = new DOMDocument();
						$xmlDoc->load($link);
						$item_image = null;
							if (count($xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')) !=0){
								$item_image = $xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('image')->item(0)->getElementsByTagName('url')->item(0)->childNodes->item(0)->nodeValue;
							}
						foreach ($xmlDoc->getElementsByTagName('item') as $item) {
							$item_title = $item->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
							$item_link = $item->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
							$item_desc = $item->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
							$item_date = $item->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue;
							$dateCheck = true;
							switch ($dateFilter) {
								case "7":
									if (strtotime("now")-strtotime($item_date)>604800) {$dateCheck = false;}
									break;
								case "2":
									if (strtotime("now")-strtotime($item_date)>172800) {$dateCheck = false;}
									break;
								case "1":
									if (strtotime("now")-strtotime($item_date)>86400) {$dateCheck = false;}
									break;
							}
							if ($dateCheck == true) {
								array_push($response->items,array("title" => $item_title, "link" => $item_link, "description" => $item_desc, "image" => $item_image, "date" =>$item_date));
							}
						}
						if (count($response->items)>1){
							foreach ($response->items as $key => $row) {
								$date[$key] = strtotime($row['date']);
							}
							array_multisort($date, SORT_DESC, $response->items);
						}
						break;
					default:
						$response->errorMessage = $response->errorMessage.'Database Inconsistency! | ';
						$response->success = false;
						return;
				}
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