<?php
class Account {

    // подключение к базе данных и имя таблицы 
    private $conn;
    private $table_name = "users";

    // свойства объекта 
    public $id;
    public $name;
    public $surname;
    public $email;
    public $company;
    public $position;
    public $phone1;
    public $phone2;
    public $phone3;

    public function __construct($db) {
        $this->conn = $db;
    }

    // метод создания аккаунта
    function create() {

        // запрос MySQL для вставки записей в таблицу БД users 
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, company_name, position, phone1, phone2, phone3)
                    VALUES (:name, :surname, :email, :company, :position, :phone1, :phone2, :phone3)";
        $stmt = $this->conn->prepare($query);

        // опубликованные значения 
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->surname=htmlspecialchars(strip_tags($this->surname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->company=htmlspecialchars(strip_tags($this->company));
        $this->position=htmlspecialchars(strip_tags($this->position));
        $this->phone1=htmlspecialchars(strip_tags($this->phone1));
        $this->phone2=htmlspecialchars(strip_tags($this->phone2));
        $this->phone3=htmlspecialchars(strip_tags($this->phone3));

        // привязываем параметры к значениям
        $stmt->bindValue(":name", $this->name);
        $stmt->bindValue(":surname", $this->surname);
        $stmt->bindValue(":email", $this->email);
        $stmt->bindValue(":company", $this->company);
        $stmt->bindValue(":position", $this->position);
        $stmt->bindValue(":phone1", $this->phone1);
        $stmt->bindValue(":phone2", $this->phone2);
        $stmt->bindValue(":phone3", $this->phone3);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }
    function readAll($from_account_num, $accounts_per_page) {

        // запрос MySQL 
        $query = "SELECT * FROM " . $this->table_name . "
                LIMIT {$from_account_num}, {$accounts_per_page}";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt;
    }

    // вычисление полного числа аккаунтов, используется для постраничного отображения
    public function countAll() {

    // запрос MySQL 
    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
    }

    function readOne() {

    // запрос MySQL 
    $query = "SELECT first_name, last_name, email, company_name, position, phone1, phone2, phone3
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['first_name'];
    $this->surname = $row['last_name'];
    $this->email = $row['email'];
    $this->company = $row['company_name'];
    $this->position = $row['position'];
    $this->phone1 = $row['phone1'];
    $this->phone2 = $row['phone2'];
    $this->phone3 = $row['phone3'];
}

function update() {

    // MySQL запрос для обновления аккаунта

    $query = "UPDATE " . $this->table_name . "
            SET
                first_name = :name,
                last_name = :surname,
                email = :email,
                company_name = :company,
                position  = :position,
                phone1  = :phone1,
                phone2  = :phone2,
                phone3  = :phone3
            WHERE id = :id";

    // подготовка запроса 
    $stmt = $this->conn->prepare($query);

    // очистка 
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->surname=htmlspecialchars(strip_tags($this->surname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->company=htmlspecialchars(strip_tags($this->company));
    $this->position=htmlspecialchars(strip_tags($this->position));
    $this->phone1=htmlspecialchars(strip_tags($this->phone1));
    $this->phone2=htmlspecialchars(strip_tags($this->phone2));
    $this->phone3=htmlspecialchars(strip_tags($this->phone3));
    $this->id=htmlspecialchars(strip_tags($this->id));


    // привязка значений 
    $stmt->bindValue(":name", $this->name);
    $stmt->bindValue(":surname", $this->surname);
    $stmt->bindValue(":email", $this->email);
    $stmt->bindValue(":company", $this->company);
    $stmt->bindValue(":position", $this->position);
    $stmt->bindValue(":phone1", $this->phone1);
    $stmt->bindValue(":phone2", $this->phone2);
    $stmt->bindValue(":phone3", $this->phone3);
    $stmt->bindParam(':id', $this->id);

    // выполняем запрос 
    if ($stmt->execute()) {
        return true;
    }

    return false;
}
    // удаление аккаунта 
    function delete() {

        // запрос MySQL для удаления 
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($result = $stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //проверка существования аккаунта с таким же email при добавлении нового аккаунта
    function validateEmail(){
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE email=:email";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindValue(":email", $this->email);

        $stmt->execute();
        if ($stmt->rowCount() > 0){
            return false;
        }
        return true;
    }
//проверка существования аккаунта с другим id и таким же email при обновлении аккаунта
    function validateEmailUpdate(){
        $query = "SELECT * FROM " . $this->table_name . "
                WHERE email=:email";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        $this->email=htmlspecialchars(strip_tags($this->email));

        $stmt->bindValue(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            foreach ($stmt as $row) {
                if ($row["id"] != $this->id){
                    return false;
                }
            }
        }
        return true;
    }
}
?>