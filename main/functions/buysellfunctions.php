<?php
function insertBuyData( $insert_data, $user_id ){
    $conn = Db_connect();
    $sendMethod = isset($insert_data['send_method']) ? sanitize( $insert_data['send_method'] ) : "" ;
    $receiveMethod = isset($insert_data['receive_method']) ? sanitize( $insert_data['receive_method'] ) : "";
    $sendAmount = isset( $insert_data['send_amount'] ) ? sanitize( $insert_data['send_amount'] ) : 0;
    $receiveAmount = isset($insert_data['receive_amount']) ? sanitize( $insert_data['receive_amount'] ) : 0;
    $bKashNumber = isset($insert_data['bKash_number']) ? sanitize( $insert_data['bKash_number'] ) : 0;
    $bKashTransactionID = isset($insert_data['bKash_tRX_ID']) ? sanitize( $insert_data['bKash_tRX_ID'] ) : 0;
    $skrillEmail = isset($insert_data['skrill_email']) ? sanitize( $insert_data['skrill_email'] ) : "";
    $contactNumber = isset( $insert_data['contact_no']) ? sanitize( $insert_data['contact_no'] ) : 0;
    $transaction_type = isset( $insert_data['transactionType']) ? sanitize( $insert_data['transactionType'] ) : NULL;
    $userID = $user_id;
    $transaction_key = substr(md5($bKashTransactionID.$transaction_type), 0, 11);
    $recorded = 1;

// Prepare the SQL statement
    $sql = $conn->prepare("INSERT INTO `buysell` ( `transaction_key` ,`send_method`, `receive_method`, `send_amount`, `receive_amount`, `bKash_number`, `bKash_tRX_ID`, `skrill_email`, `contact_no`, `user_id`, `recorded`, `transaction_type` ) 
                       VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// Bind parameters
    $sql->bind_param("sssiiiisiiis", $transaction_key, $sendMethod, $receiveMethod, $sendAmount, $receiveAmount, $bKashNumber, $bKashTransactionID, $skrillEmail, $contactNumber, $userID, $recorded, $transaction_type );
// Execute the statement
    if ($sql->execute()) {
        $result = array(
            'success' => true,
            'message'=>"New record created successfully",
            'status_code'=>202
        );
    } else {
        $result = array(
            'success' => false,
            'message'=>"Error: " . $sql->error,
            'status_code'=>303
        );
    }
// Close the statement and connection
    $sql->close();
    $conn->close();
    return $result;
}

function selectBuySellData( $user_id= '' , $transaction_type='', $already_loaded_ids=[] ) {
    $conn = Db_connect();

    if( count( $already_loaded_ids )> 0 ){
        $already_loaded_ids_str = implode( ",",$already_loaded_ids);
        $not_Id = " `id` NOT IN($already_loaded_ids_str) ";
        $is_loaded = true;
    }else{
        $not_Id = "";
        $is_loaded = false;
    }

    $bindPrm = true;
    $and = true;
    $is_multiple = 0;
    if( $user_id ==='' &&  $transaction_type === '' ){
        $condition = '';
        $prepare = '';
        $value = "";
        $bindPrm =false;
        $and = false;
    }else if( $user_id !=='' &&  $transaction_type === '' ){
        $condition = "WHERE `user_id` = ?";
        $prepare = 'i';
        $value = "$user_id";
    }else if( $user_id ==='' &&  $transaction_type !== '' ){
        $condition = "WHERE `transaction_type` = ?";
        $prepare = 's';
        $value = "$transaction_type";
    }else{
        $condition = "WHERE `user_id`=? AND `transaction_type` = ?";
        $prepare = "is";
        $is_multiple = 1;
        $value = "$user_id, $transaction_type";
    }

    if( $is_loaded === true && $and === true ){
        $and = "AND";
    }else{
        $and = "";
    }
    // Define the query with a prepared statement
    $query = "SELECT * FROM `buysell` INNER JOIN users ON `buysell`.`user_id` = `users`.`id` $condition $and $not_Id ";
    $stmt = $conn->prepare($query);
    if( $bindPrm ){
        if( $is_multiple === 1 ){
            $stmt->bind_param( $prepare, $user_id, $transaction_type );
        }else{
            $stmt->bind_param( $prepare, $value );
        }

    }
    // Execute the query
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the rows into an associative array
    $data = array();
    while ($row = $result->fetch_assoc()) {
        unset($row['ID']);
        unset($row['admin']);
        unset($row['admin_id']);
        unset($row['password']);
        unset($row['user_id']);
        unset($row['id']);
        unset($row['username']);
        unset($row['active']);
        $data[] = $row;

    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();

    return $data;
}
