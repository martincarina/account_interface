<?php
// установка заголовка страницы 
$page_title = "Welcome!";

require_once "header.php";
?>

<div class='select'>
    <h2> Select the action:</h2>
    <ul>
        <li><a href="create_account.php">Create new account</a></li>
        <li><a href ="view_accounts.php">View the list of accounts</a></li>
    </ul>
</div>

<?php // подвал 
require_once "footer.php";
?>