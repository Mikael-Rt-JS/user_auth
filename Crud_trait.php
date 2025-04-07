<?php

trait CrudTrait {
    protected static string $table = '';

    protected static function db(): PDO {
        return MySQL::getConnection()->getConnection();
    }

    public static function create(array $data) {
        $db = static::db();
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        return $db->lastInsertId();
    }

    public static function read(int $id) {
        $db = static::db();
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update(int $id, array $data) {
        $db = static::db();
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $data['id'] = $id;
        $sql = "UPDATE " . static::$table . " SET $set WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    public static function delete(int $id) {
        $db = static::db();
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public static function findAll() {
        $db = static::db();
        $sql = "SELECT * FROM " . static::$table;
        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function where(array $conditions, string $operator = 'AND') {
        $db = static::db();
        $clauses = implode(" $operator ", array_map(fn($k) => "$k = :$k", array_keys($conditions)));
        $sql = "SELECT * FROM " . static::$table . " WHERE $clauses";
        $stmt = $db->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function paginate(int $page = 1, int $perPage = 10) {
        $db = static::db();
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM " . static::$table . " LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function count(): int {
        $db = static::db();
        $sql = "SELECT COUNT(*) FROM " . static::$table;
        return (int) $db->query($sql)->fetchColumn();
    }
}

class User {
    use CrudTrait;
    protected static string $table = 'users';
}

// Все пользователи
$all = User::findAll();

// Пользователи с определённым телефоном
$filtered = User::where(['phone' => '+37444123456']);

// Пагинация
$pageData = User::paginate(2, 10); // 2-я страница, 10 записей

// Кол-во всех
$count = User::count();

// Создание нового пользователя
User::create([
    'name' => 'Arman',
    'surname' => 'Hakobyan',
    'email' => 'arman@example.com',
    'phone' => '+37499111222',
    'password' => password_hash('secret', PASSWORD_DEFAULT)
]);

// Обновление
User::update(3, [
    'email' => 'new_email@example.com'
]);

// Удаление
User::delete(5);

// Где phone равен ...
$users = User::where(['phone' => '+37444123456']);






