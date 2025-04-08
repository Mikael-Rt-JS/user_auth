trait TraitCrudStatic {
    protected static string $table;

    public static function create(PDO $connection, array $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $connection->prepare($sql);
        $stmt->execute($data);
        return $connection->lastInsertId();
    }

    public static function read(PDO $connection, int $id) {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update(PDO $connection, int $id, array $data) {
        $set = implode(', ', array_map(function($k) {
            return "$k = :$k";
        }, array_keys($data)));
        $data['id'] = $id;
        $sql = "UPDATE " . static::$table . " SET $set WHERE id = :id";
        $stmt = $connection->prepare($sql);
        return $stmt->execute($data);
    }

    public static function delete(PDO $connection, int $id) {
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";
        $stmt = $connection->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

trait TraitCrudDynamic {
    public static function create(PDO $connection, string $table, array $data) {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $connection->prepare($sql);
        $stmt->execute($data);
        return $connection->lastInsertId();
    }

    public static function read(PDO $connection, string $table, int $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update(PDO $connection, string $table, int $id, array $data) {
        $set = implode(', ', array_map(function($k) {
            return "$k = :$k";
        }, array_keys($data)));
        $data['id'] = $id;
        $sql = "UPDATE $table SET $set WHERE id = :id";
        $stmt = $connection->prepare($sql);
        return $stmt->execute($data);
    }

    public static function delete(PDO $connection, string $table, int $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $stmt = $connection->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

require_once 'MySQL.php';
$connection = MySQL::getConnection()->getConnection();

// Добавление
Product::create($connection, ['name' => 'Milk', 'price' => 200]);

// Получение
$product = Product::read($connection, 1);

// Обновление
Product::update($connection, 1, ['price' => 250]);

// Удаление
Product::delete($connection, 1);

