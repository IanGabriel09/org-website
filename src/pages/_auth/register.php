<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';
require_once '../../../conn.php';

// Function to generate a custom UUID
function generateCustomUUID() {
    $randomNumber = mt_rand(100000, 999999); // Ensure it's a 6-digit number
    return "UUID" . $randomNumber;
}

// Function to generate a token ID
function generateTokenID() {
    $randomNumber = mt_rand(100000, 999999); // Ensure it's a 6-digit number
    return "TK" . $randomNumber;
}

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

$tokenID = generateTokenID();
$uuid = generateCustomUUID();
$name = $_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];

// Hash the password
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

// Check if the email is already in the database
$checkStmt = $conn->prepare('SELECT * FROM user_table WHERE email = ?');
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'This email is already in use. Please choose a different email.'
    ]);
} else {
    // Insert new user into the database
    $insertStmt = $conn->prepare('INSERT INTO user_table (tk_id, user_id, name, email, password) VALUES (?, ?, ?, ?, ?)');
    $insertStmt->bind_param("sssss", $tokenID, $uuid, $name, $email, $hashedPass);
    
    if($insertStmt->execute()) {
        // Construct verification link
        $verificationLink = "http://localhost/orgWebsite(Pre-Alpha)/src/pages/_auth/verify.php?tokenID=$tokenID&uuid=$uuid&email=$email";

        // Send verification email using PHPMailer
        try {
            $mail = new PHPMailer(true);
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'koufusmtp@gmail.com'; // SMTP username
            $mail->Password = 'grqq xrbk bpzg dutm'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; 

            // Recipients
            $mail->setFrom('koufusmtp@gmail.com', 'Sample Company');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Please click the link below to verify your email address: <br><a href='$verificationLink'>Verify Account</a>";

            // Send email
            $mail->send();

            echo json_encode([
                'status' => 'success',
                'message' => 'Registration in process. Please check your email to verify your email.'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mailer Error: ' . $mail->ErrorInfo
            ]);
        }

    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'An error occurred while inserting user data. Please try again later.'
        ]);
    }

    $insertStmt->close();
}

$checkStmt->close();
$conn->close();
?>
