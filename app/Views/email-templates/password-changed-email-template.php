<p>Dear <?= $mail_data['user']->name ?></p>
<br>
<p>
    your password on CI4Blog system was changed successfully. here are your new logn credentials
    <br>
    <br>
    <b>login ID:</b> <?= $mail_data['user']->username ?> or <?= $mail_data['user']->email ?>
    <br>
    <b>Password:</b> <?= $mail_data['new_password'] ?>
</p>

<br><br>
please, keep your credentials confidentials. your username and password are your own credentials and you should never
share with anybody else
<p>
    CI4Blog will not be liable for any misuse of your username or password.
</p>

<br>
-------------------------------------------------------
<p>
    this email was automatically sent by CI4Blog system. do not reply it.
</p>