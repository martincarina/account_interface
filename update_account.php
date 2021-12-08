<?php
// получаем ID редактируемого аккаунта 
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// подключим файлы, необходимые для подключения к базе данных и файл с классом Account
include_once 'config/database.php';
include_once 'model/account.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// создадим экземпляр класса Account 
$account = new Account($db);

// устанавливаем свойство ID аккаунта для редактирования 
$account->id = $id;

// получаем информацию о редактируемом аккаунте
$account->readOne();

// установка заголовка страницы 
$page_title = "Update account";

include_once "header.php";
?>

<!-- ссылка на главную страницу-->
<div class='tomain'>
    <a href='main.php'>To the main page</a>
</div>

<?php
// если форма была отправлена (submit) 
if ($_POST) {
    if (trim($_POST['name']) && trim($_POST['surname']) && trim($_POST['email'])) {

        // устанавливаем значения полей аккаунта
        $account->name = $_POST['name'];
        $account->surname = $_POST['surname'];
        $account->email = $_POST['email'];
        $account->company = $_POST['company'];
        $account->position = $_POST['position'];
        $account->phone1 = $_POST['phone1'];
        $account->phone2 = $_POST['phone2'];
        $account->phone3 = $_POST['phone3'];

        //проверка существования аккаунта с другим id и таким же email при обновлении аккаунта
        if($account->validateEmailUpdate()){

        // обновление аккаунта 
            if ($account->update()) {
                echo "<p class='successtext'>Account was successfully updated.</p>";
            }

        // если не удается обновить аккаунт, сообщим об этом пользователю 
            else {
                echo "<p class='failtext'> Account wasn't updated.</p>";
            }
        }
        else {
            echo "<p class='failtext'>Account wasn't updated. Another account with this email already exists!</p>";
    }
    }
    else {
        echo "<p class='failtext'> Account wasn't updated! Some of required fields are empty!</p>";
    }
}
?>

<!-- HTML-форма для редактирования аккаунта -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
<div class="container">
        <p>Please fill in this form to update an account.</p>

        <label for="name"><b>First name*</b></label>
        <p> <input type="text" placeholder="Enter first name" name="name" value='<?php echo $account->name ?>' required></p>

        <label for="surname"><b>Last name*</b></label>
        <p><input type="text" placeholder="Enter last name" name="surname" value='<?php echo $account->surname ?>' required></p>

        <label for="email"><b>Email*</b></label>
        <p><input type="text" placeholder="Enter Email" name="email" value='<?php echo $account->email ?>' required></p>

        <label for="company"><b>Company name</b></label>
        <p><input type="text" placeholder="Enter company name" name="company" value='<?php echo $account->company ?>'></p>

        <label for="position"><b>Position</b></label>
        <p><input type="text" placeholder="Enter position" name="position" value='<?php echo $account->position ?>'></p>
        
        <label for="phone1"><b>Phone number 1</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone1" value='<?php echo $account->phone1 ?>'></p>
        
        <label for="phone2"><b>Phone number 2</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone2" value='<?php echo $account->phone2 ?>'></p>

        <label for="phone3"><b>Phone number 3</b></label>
        <p><input type="text" placeholder="Enter phone number" name="phone3" value='<?php echo $account->phone3 ?>'></p>

        <p>* - required to be filled in</p>
        <button type="submit" class="registerbtn">Update</button>
    </div>
</form>

<?php // подвал 
require_once "footer.php";
?>