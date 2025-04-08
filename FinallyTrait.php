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

----

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
    $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
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

public static function findAll(PDO $connection) {
    $sql = "SELECT * FROM " . static::$table;
    return $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public static function where(PDO $connection, array $conditions, string $operator = 'AND') {
    $clauses = implode(" $operator ", array_map(fn($k) => "$k = :$k", array_keys($conditions)));
    $sql = "SELECT * FROM " . static::$table . " WHERE $clauses";
    $stmt = $connection->prepare($sql);
    $stmt->execute($conditions);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function paginate(PDO $connection, int $page = 1, int $perPage = 10) {
    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM " . static::$table . " LIMIT :limit OFFSET :offset";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function count(PDO $connection): int {
    $sql = "SELECT COUNT(*) FROM " . static::$table;
    return (int) $connection->query($sql)->fetchColumn();
}

------

public static function read(PDO $connection, string $table, int $id, array $columns = ['*']) {
    $cols = implode(', ', $columns);
    $sql = "SELECT $cols FROM $table WHERE id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function findAll(PDO $connection, string $table, array $columns = ['*']) {
    $cols = implode(', ', $columns);
    $sql = "SELECT $cols FROM $table";
    return $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public static function where(PDO $connection, string $table, array $conditions, string $operator = 'AND', array $columns = ['*']) {
    $cols = implode(', ', $columns);
    $clauses = implode(" $operator ", array_map(fn($k) => "$k = :$k", array_keys($conditions)));
    $sql = "SELECT $cols FROM $table WHERE $clauses";
    $stmt = $connection->prepare($sql);
    $stmt->execute($conditions);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function paginate(PDO $connection, string $table, int $page = 1, int $perPage = 10, array $columns = ['*']) {
    $offset = ($page - 1) * $perPage;
    $cols = implode(', ', $columns);
    $sql = "SELECT $cols FROM $table LIMIT :limit OFFSET :offset";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

TraitCrudDinamic::findAll($connection, 'products', ['id', 'name', 'price']);
TraitCrudDinamic::read($connection, 'users', 5, ['name', 'email']);
TraitCrudDinamic::paginate($connection, 'orders', 2, 10, ['id', 'status']);






