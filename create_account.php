<?php

// подключим файлы, необходимые для подключения к базе данных и файл с классом
include_once 'config/database.php';
include_once 'model/account.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// создадим экземпляр класса Account 
$account = new Account($db);

// установка заголовка страницы 
$page_title = "Creating account";

require_once "header.php";
?>

<!-- ссылка на главную страницу-->
<div class='tomain'>
    <a href='main.php'>To the main page</a>
</div>

<?php
// если форма была отправлена 
if ($_POST) {
    if (trim($_POST['name']) && trim($_POST['surname']) && trim($_POST['email'])) {

        // установим значения полям аккаунта
        $account->name = $_POST['name'];
        $account->surname = $_POST['surname'];
        $account->email = $_POST['email'];
        $account->company = $_POST['company'];
        $account->position = $_POST['position'];
        $account->phone1 = $_POST['phone1'];
        $account->phone2 = $_POST['phone2'];
        $account->phone3 = $_POST['phone3'];

        if($account->validateEmail()){

            // создание товара 
            if ($account->create()) {
                echo "<p class='successtext'> Account was successfully created.</p>";
            }

        // если не удается создать аккаунт, сообщим об этом пользователю 
            else {
                echo "<p class='failtext'>Account wasn't created.</p>";
            }
        }
        else {
                echo "<p class='failtext'>Account wasn't created. Account with this email already exists!</p>";
        }
    }
    else {
        echo "<p class='failtext'>Account wasn't created! Some of required fields are empty!</p>";
    }
}
?>

<!-- HTML-форма для создания аккаунта -->

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="container">
        <p>Please fill in this form to create an account.</p>

        <label for="name"><b>First name*</b></label>
        <p> <input type="text" placeholder="Enter first name" name="name" required></p>

        <label for="surname"><b>Last name*</b></label>
        <p><input type="text" placeholder="Enter last name" name="surname" required></p>

        <label for="email"><b>Email*</b></label>
        <p><input type="text" placeholder="Enter Email" name="email" required></p>

        <label for="company"><b>Company name</b></label>
        <p><input type="text" placeholder="Enter company name" name="company"></p>

        <label for="position"><b>Position</b></label>
        <p><input type="text" placeholder="Enter position" name="position"></p>
        
        <label for="phone1"><b>Phone number 1</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone1"></p>
        
        <label for="phone2"><b>Phone number 2</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone2"></p>

        <label for="phone3"><b>Phone number 3</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone3"></p>

        <p>* - required to be filled in</p>
        <button type="submit" class="registerbtn">Create</button>
    </div>
</form>


<?php // подвал 
require_once "footer.php";
?>