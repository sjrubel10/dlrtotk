<?php
/**
 * Created by PhpStorm.
 * User: Sj
 * Date: 10/9/2023
 * Time: 10:40 PM
 */
function var_test_die( $data ){
    echo "<pre>";
        var_dump($data);
    echo "</pre>";
    die();
}
function var_test( $data ){
    echo "<pre>";
        var_dump($data);
    echo "</pre>";
}
function getUserIdByProfileKey( $profileKey ) {
    $conn = Db_connect();

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id FROM users WHERE userkey = ?";
    $stmt = $conn->prepare($sql);
    if( $stmt ) {
        $stmt->bind_param("s", $profileKey);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
    }else{
        $userId = false;
    }

    return $userId;
}

function getUserIdByusername( $username ) {
    $conn = Db_connect();

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id FROM users WHERE `username` = ?";
    $stmt = $conn->prepare( $sql );
    if( $stmt ){
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();

        $conn->close();
    }else{
        $userId = false;
    }


    return $userId;
}

function getUserDataById( $userId ) {
    $conn = Db_connect();
    $sql = "SELECT * FROM users WHERE id = $userId";
    $stmt = $conn->prepare($sql);
//    $stmt->bind_param("i", $userId);
    if( $stmt ){
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
    }else{
        $userData = [];
    }

    return $userData;
}

function user_registration( $user_input_data, $profileimage ){
    $conn = Db_connect();
    $email = isset( $user_input_data['email'] ) ? sanitize( $user_input_data['email'] ) : "" ;
    $delimiter = "@";
    $email_explode = explode($delimiter, $email);
    $username = $email_explode[0];

// Print the result
    $password = password_hash( $user_input_data['password'], PASSWORD_DEFAULT );
    $firstName = isset( $user_input_data['firstName'] ) ? sanitize($user_input_data['firstName'] ) : "";
    $gender =  isset( $user_input_data['gender'] ) ? sanitize($user_input_data['gender']): "";
    $userkey = substr(md5($firstName.$email), 0, 8);

    $result = 0;
// Prepare the SQL statement with placeholders
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } else {
        $sql = "INSERT INTO users ( `mail`, username, `userkey`, `profileimage` , `password`, `full_name`, `gender` ) VALUES ( ?, ?, ?, ?, ?, ?, ? )";
        $stmt = $conn->prepare($sql);
        if( $stmt ){
            $stmt->bind_param("sssssss", $email, $username, $userkey, $profileimage, $password, $firstName, $gender );
            if ( $stmt->execute() ) {
                $result = 'User Account Successfully Created';
            } else {
                $result = 'User Account Created Fail';
            }
            $stmt->close();
            $conn->close();
        }else{
            $result = 'Database Error';
        }

    }

    return $result;
}

function getUsersData( $conn, $already_loaded_ids = [], $limit = 20 ) {
    $usersData = array();

    if( count( $already_loaded_ids )> 0){
        $already_loaded_ids_str = implode(",",$already_loaded_ids);
        $notIn = "AND `id` NOT IN( $already_loaded_ids_str )";
    }else{
        $notIn = "";
    }
    // SQL query to select data from the users table
    $sql = "SELECT * FROM users WHERE `recorded` = 1 $notIn ORDER BY `id` LIMIT $limit";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch data from each row and store it in the $usersData array
        while($row = $result->fetch_assoc()) {
            unset( $row['password']);
            unset( $row['id']);
            $usersData[] = $row;
        }
    }

    // Return the array containing users' data
    return $usersData;
}

function user_admin_status( $status_number ){
    $admis_status= array(
        1=>'Super Admin',
        2=>'Admin',
        3=>'Modaretor',
    );

    return $admis_status[$status_number];
}

function updateUserToActivated( $userid, $active ) {
    $conn = Db_connect();
    $result = false;
    $sql = " UPDATE `users` SET `active` = $active, `recorded` = 1 WHERE `id` = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in the prepared statement: " . $conn->error);
    }
    // Bind the parameter
    $stmt->bind_param("i", $userid ); // "i" represents an integer
    // Execute the statement
    $result = $stmt->execute();
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    return $result;
}

function sendActivationEmail( $userEmail, $fromSentMail ) {
    $to = $userEmail;
    $subject = "User Successfully Activated";
    $message = "Dear user, your account has been successfully activated. You can now log in and start using our services.";

    $headers = "From: $fromSentMail" . "\r\n" .
        "Content-Type: text/plain; charset=UTF-8" . "\r\n";

    // Use the mail() function to send the email
    if ( mail( $to, $subject, $message, $headers ) ) {
        return true;
    } else {
        return false;
    }
}