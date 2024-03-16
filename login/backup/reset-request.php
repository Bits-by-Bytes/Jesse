<?php

    // Check if email is provided via POST
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Generate random token and hash it
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);

        // Calculate token expiry time (30 minutes from now)
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

        // Include database connection
        $mysqli = require "../common/database.php";

        // Prepare SQL statement to update token and expiry time
        try {
        $sql = "UPDATE login
            SET RESET_TOKEN = ?,
                RESET_TOKEN_EXP = ?
            WHERE EMAIL = ?";
        }
        catch (exception $e) {
            echo "not inserting into database";
            die();
        }

        try {echo $sql;
            $stmt = $mysqli->prepare($sql);
        }
        catch (exception $e) {
            echo "not inserting into database";
            die();
        }
        

        // Bind parameters and execute query
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows) {
            // Include mailer script
            require_once "mailer.php";

            // Compose email
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Password Reset";
            $mail->Body = "Click <a href='http://172.22.2.83/login/reset-pass.php?token=$token_hash'>here</a> to reset your password.";

            try {
                // Send email
                $mail->send();
                // Redirect to success page
                header('Location: send-email.php?reset=success');
                exit;
            } catch (Exception $e) {
                // Handle email sending error
                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            // Handle database update error
            echo "Error updating database.";
        }
    } else {
        // Handle case where email is not provided
        echo "Email is required.";
    }
?>
