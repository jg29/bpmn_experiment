<!-- resources/views/emails/password.blade.php -->

<h3>PEx-Account</h3>

Um auf ihren PEx-Account zugreifen zu können, klicken sie bitte auf den Link um ein Passwort zu vergeben.<br><br>

{{ url('password/reset/'.$token) }}