<?php
// установка заголовка страницы 
$page_title = "Deleting account";

require_once "header.php";

?>
<!-- ссылка на главную страницу-->
<div class='tomain'>
    <a href='main.php'>To the main page</a>
</div>

<?php
// проверим, было ли получено значение в $_POST 
if ($_POST) {

    // подключим файлы, необходимые для подключения к базе данных и файл с классом
    include_once 'config/database.php';
    include_once 'model/account.php';

    // получаем соединение с базой данных 
    $database = new Database();
    $db = $database->getConnection();

    // создадим экземпляр класса Account 
    $account = new Account($db);

    // устанавливаем ID аккаунта для удаления 
    $account->id = $_POST['id'];

    // удаляем аккаунт
    if ($account->delete()) {
        echo "<p class='successtext'> Account was removed.</p>";
    }

    // если невозможно удалить аккаунт
    else {
        echo "<p class='failtext'> Account wasn't removed.</p>";
    }
}
?>

<?php // подвал 
require_once "footer.php";
?>