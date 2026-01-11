<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require_once 'connection.php';
if (isset($_REQUEST['forgot'])) {
  $email  =   $_POST['email'];
  $sel_admin_qry = "select id, email, first_name, last_name from users where email='$email' and status='0'";
  $sel_admin = mysqli_query($conn, $sel_admin_qry);
  $fetch_row = mysqli_fetch_assoc($sel_admin);
  if ($fetch_row) {
    $new_password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") . time(), 0, 10);
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $mail   =    sendPasswordResetEmail($fetch_row['email'], $fetch_row['first_name'] . ' ' . $fetch_row['last_name'], $new_password);
    if ($mail == 1) {
      $userId       =   $fetch_row['id'];
      $updateQuery  =   "UPDATE users SET password = '$hashed_password' WHERE id = $userId";
      $res  =   mysqli_query($conn, $updateQuery);
      $_SESSION['success_msg'] = 'Reset paasword send successfully';
      header("Location: ../login.php");
      exit;
    } else {
      $_SESSION['error_msg'] = 'Something went wrong!';
    }
  } else {
    $_SESSION['error_msg'] = 'Wrong Email';
  }
  header("Location: ../forgot_password.php");
  exit;
}

function sendPasswordResetEmail($userEmail, $userName, $password)
{
  $mail = new PHPMailer(true);

  try {
    $mail->SMTPDebug = 2; // Enable debugging
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'support@shopercity.com';
    $mail->Password = 'Chirag@host$123';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
    $mail->Port = 587; // Change from 465 to 587

    $mail->setFrom('support@shopercity.com', 'Shopercity Support');
    $mail->addAddress($userEmail, 'Recipient Name');

    $mail->isHTML(true);
    $mail->Subject = 'Forgot Password';
    $mail->Body = '
        <!DOCTYPE html>
<html lang="fr" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <meta name="color-scheme" content="light">
  <meta name="supported-color-schemes" content="light">
  <title></title>
  <!--[if gte mso 9]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]--> <!--[if (gte mso 9)|(IE)]>
    <style>
      table,td,p,a,span {font-family: Arial, sans-serif !important;}
      a {text-decoration: none;}
    </style>
    <![endif]-->
  <style>
    @media screen {
      @font-face {
        font-family: `Prata`;
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/prata/v18/6xKhdSpbNNCT-sWPCm4.woff2) format(`woff2`);
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }

      @font-face {
        font-family: `Josefin Sans`;
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/josefinsans/v26/Qw3PZQNVED7rKGKxtqIqX5E-AVSJrOCfjY46_GbQbMZhLw.woff2) format(`woff2`);
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
      }
    }

    :root {
      color-scheme: light;
      supported-color-schemes: light;
    }

    html,
    body {
      margin: 0 auto !important;
      padding: 0 !important;
      height: 100% !important;
      width: 100% !important;
    }

    div[style*="margin: 16px 0"] {
      margin: 0 !important;
    }

    table,
    td {
      mso-table-lspace: 0pt !important;
      mso-table-rspace: 0pt !important;
    }

    table {
      border-spacing: 0 !important;
      border-collapse: collapse !important;
      table-layout: fixed !important;
      margin: 0 auto !important;
      mso-table-lspace: 0;
      mso-table-rspace: 0;
    }

    h2,
    h3 {
      padding: 0;
      margin: 0;
      border: 0;
      background: none;
    }
  </style>
  <style>
    span.MsoHyperlink {
      color: inherit !important;
      mso-style-priority: 99 !important;
    }

    span.MsoHyperlinkFollowed {
      color: inherit !important;
      mso-style-priority: 99 !important;
    }

    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    [x-apple-data-detectors-type="calendar-event"] {
      color: inherit !important;
      -webkit-text-decoration-color: inherit !important;
      text-decoration: none !important;
    }

    u+.body a {
      color: inherit;
      text-decoration: none;
      font-size: inherit;
      font-weight: inherit;
      line-height: inherit;
    }

    #MessageViewBody a {
      color: inherit;
      text-decoration: none;
      font-size: inherit;
      font-family: inherit;
      font-weight: inherit;
      line-height: inherit;
    }
  </style>
  <!--[if gte mso 9]>
    <style>
      .w-60{
      width:60px !important;
      }
      .p-54-94-30{
      padding:54px 94px 30px !important
      }
      .p-33-36-0{
      padding:33px 36px 0 !important;
      }
      .cc-258 img{
      max-width:258px !important;
      }
      .cc-187 img{
      max-width: 187px !important;
      }
      .p-30-37{
      padding:30px 37px !important;
      }
      .p-25-32{
      padding:25px 32px !important
      }
      }
    </style>
    <![endif]-->
  <style>
    @media screen and (min-width:680px) {
      .w-60 {
        width: 60px !important;
      }

      .p-54-94-30 {
        padding: 54px 94px 30px !important
      }

      .p-33-36-0 {
        padding: 33px 36px 0 !important;
      }

      .cc-258 {
        width: 100% !important;
        max-width: 258px !important;
      }

      .cc-187 {
        width: 100% !important;
        max-width: 187px !important;
      }

      .cc-258 img {
        max-width: 258px !important;
      }

      .cc-187 img {
        max-width: 187px !important;
      }

      .p-30-37 {
        padding: 30px 37px !important;
      }

      .p-25-32 {
        padding: 25px 32px !important
      }
    }
  </style>
</head>

<body style="margin: 0 auto !important; padding: 0 !important;">
  <center role="article" aria-roledescription="email" aria-label="Hôtel Saint Marc" lang="fr" dir="ltr"
    style="width: 100%;">
    <div style="display:none;max-height:0;overflow:hidden">
      &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
    </div>
    <div style="max-width: 600px; margin: 0 auto;">
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
        style="margin: auto;background-color:#F5E7E7;font-size:0">
        <tr>
          <td class="w-60" style="width:30px">&nbsp;</td>
          <td align="center" style="padding:30px 0 0;">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
              style="width:100%;margin: auto;border-collapse: separate !important">
              <tr>
                <td align="center"
                  style="border-left:1px solid #B49C71;border-right:1px solid #B49C71;border-top:1px solid #B49C71;border-top-left-radius:238px;border-top-right-radius:238px;">
                  <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
                    style="width:100%;margin: auto;border-collapse: separate !important">
                    <tr>
                      <td class="p-54-94-30" align="center" style="padding:54px 30px 30px">
                        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
                          style="width:100%;margin: auto;">
                          <tr>
                            <td align="center">
                              <img src="https://shopercity.com/assets/images/logo.png" width="75" height="87" alt=""
                                style="width:100px;height:90px;display:block;border:0;margin:0 auto">
                            </td>
                          </tr>
                          <tr>
                            <td align="center"
                              style="padding-top:51px;font-family: `Prata`,`Arial`, sans-serif; font-size:14px; mso-line-height-rule: exactly;line-height: 21px; color: #000000;text-align:center">
                              <h1
                                style="margin:0;font-family: `Prata`,`Arial`, sans-serif; font-size:14px; mso-line-height-rule: exactly;line-height: 1.5; color: #000000;">
                                FORGOT PASSWORD</h1>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td class="w-60" style="width:30px">&nbsp;</td>
        </tr>
        <tr>
          <td class="w-60" style="width:30px;border-top:1px solid #B49C71"></td>
          <td align="center" valign="top" style="border-top:1px solid #B49C71">
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
              style="width:100%;margin: auto;">
              <tr>
                <td align="center" style="border-left:1px solid #B49C71;border-right:1px solid #B49C71">
                  <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0"
                    style="width:100%;margin: auto;">
                    <tr>
                      <td class="p-33-36-0" align="center"
                        style="padding:33px 30px 0;font-family: `Arial`, sans-serif; font-size:12px; mso-line-height-rule: exactly;line-height: 1.5; color: #707070;text-align:center;">
                        <p style="margin:0 0 20px">Dear, ' . $userName . '</p>
                        <p style="margin:0 0 20px">We received a request to reset your password for your account. Your new password is:
                        </p>
                        <p style="margin:0 0 20px;border: 1px solid;padding: 5px 10px !important;border-radius: 4px;">' . $password . '</p>
                        <p style="margin:0 0 20px">For security reasons, we recommend changing this password after logging in.<br>
                          If you did not request this change, please contact our support team immediately.<br>
                          Best regards,</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td class="w-60" style="width:30px;border-top:1px solid #B49C71"></td>
        </tr>
        <tr>
          <td class="w-60" style="width:30px;border-top:1px solid #B49C71"></td>
          <td align="center" valign="top" style="border-top:1px solid #B49C71">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="width:100%;margin: auto;">
              <tr>
                <td class="p-25-32" style="padding:25px 32px">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0"
                    style="width:100%;margin: auto;">
                    <tr>
                      <td align="center"
                        style="font-family: `Arial`, sans-serif; font-size:10px; mso-line-height-rule: exactly;line-height: 1.5; color: #707070;text-align:center;padding-bottom:8px">
                        <p style="margin:0">Vasana, AHMEDABAD - 380051</p>
                        <p style="margin:0">
                          Tel :<a href="tel:+919909503062" style="text-decoration:none;color:#707070"> +91 99095 03062</a> |
                          Tel :<a href="tel:+919265744500" style="text-decoration:none;color:#707070"> +91 92657 44500</a> |
                          <a href="https://shopercity.com" style="text-decoration:none;color:#707070">
                            shopercity</a>
                        </p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td class="w-60" style="width:30px;border-top:1px solid #B49C71"></td>
        </tr>
      </table>
    </div>
  </center>
</body>

</html>';

    // Send Email
    $mail->send();
    return 1;
  } catch (Exception $e) {
    return 0;
  }
}
