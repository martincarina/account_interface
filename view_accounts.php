<?php
// страница, указанная в параметре URL, страница по умолчанию - 1 
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// устанавливаем ограничение количества записей на странице 
$accounts_per_page = 10;

// подсчитываем количество выводимых аккаунтов
$from_account_num = ($accounts_per_page * $page) - $accounts_per_page;

// подключим файлы, необходимые для подключения к базе данных и файл с классом Account
include_once 'config/database.php';
include_once 'model/account.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// создадим экземпляр класса Account 
$account = new Account($db);

// запрос списка аккаунтов 
$stmt = $account->readAll($from_account_num, $accounts_per_page);
$num = $stmt->rowCount();
// здесь будет получение товаров из БД

// установка заголовка страницы 
$page_title = "List of accounts";

require_once "header.php";
?>

<!-- ссылка на главную страницу-->
<div class='tomain'>
    <a href='main.php'>To the main page</a>
</div>

<?php
// отображаем аккаунты, если они есть 
if ($num > 0) {

    echo "<table class='table'>";
        echo "<tr>";
            echo "<th>Id</th>";
            echo "<th>First name</th>";
            echo "<th>Last name</th>";
            echo "<th>Email</th>";
            echo "<th>Company name</th>";
            echo "<th>Position</th>";
            echo "<th>Phone number 1</th>";
            echo "<th>Phone number 2</th>";
            echo "<th>Phone number 3</th>";
            echo "<th>Update</th>";
            echo "<th>Delete</th>";

        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$first_name}</td>";
                echo "<td>{$last_name}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$company_name}</td>";
                echo "<td>{$position}</td>";
                echo "<td>{$phone1}</td>";
                echo "<td>{$phone2}</td>";
                echo "<td>{$phone3}</td>";
                // ссылки для редактирования и удаления аккаунта 
                echo "<td><button class='btn-update' onclick=\"window.location.href = 'update_account.php?id={$id}';\">Update</button></td>";
  
                echo "<td><form action='delete_account.php' method='post' onSubmit=\"javascript: return confirm('Please confirm deletion');\">
                        <input type='hidden' name='id' value='{$id}' />
                        <input type='submit' class='btn-delete' value='Delete'>
                    </form></td>";
            echo "</tr>";
        }
    echo "</table>";

   // страница, на которой используется постраничное отображение
    $page_url = "view_accounts.php?";

    // подсчёт всех аккаунтов в базе данных, чтобы подсчитать общее количество страниц 
    $total_rows = $account->countAll();

    // постраничное отображение 
    include_once 'paging.php';
}

// сообщим пользователю, что аккаунтов нет 
else {
    echo "<p class='failtext'> Аккаунты не найдены.</p>";
}
?>

<?php // подвал 
require_once "footer.php";
?>