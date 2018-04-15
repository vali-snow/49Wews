<?php
    try {
        //Initialize Response
        $response = new StdClass();
        $response->success = true;
        $response->errorMessage = '';
        $response->username = $_POST['username'];
        $response->email = $_POST['email'];
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
        //Register the new reader
        try{
            $stmt = $db->prepare("INSERT INTO Readers (Username, Email, Password) VALUES (?,?,?)");
            $stmt->execute(array($response->username, $response->email, $response->password));
            if($stmt->rowCount() != 1) {
                $response->errorMessage = $response->errorMessage.'Database Inconsistency!';
                $response->success = false;
                return;
            }
        } catch(Exception $e) {
            $response->errorMessage = $response->errorMessage.'Unable to register: '.$e->getMessage().' | ';
            $response->success = false;
            return;
        }
    } catch(Exception $e) {
        $response->errorMessage = $response->errorMessage.'Other: '.$e->getMessage().' | ';
        $response->success = false;
    } finally {
        //Disconnect from the MySql Database
        $stmt = null;
        $db = null;
        //Pretify response
        unset($response->username);
        unset($response->email);
        unset($response->password);
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