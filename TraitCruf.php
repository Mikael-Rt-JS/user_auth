trait TraitCrud {
    protected static string $table = '';

    // Используем подключение через синглтон
    protected static function db(): PDO {
        return MySQL::getConnection()->getConnection(); // Получаем соединение из синглтона
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

    public static function read(int $id, array $columns = ['*']) {
        $db = static::db();
        $columnsString = implode(',', $columns);
        $sql = "SELECT $columnsString FROM " . static::$table . " WHERE id = :id";
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

    public static function findAll(array $columns = ['*'], array $conditions = [], string $operator = 'AND', array $orderBy = [], int $limit = 10, int $offset = 0) {
        $db = static::db();
        $columnsString = implode(',', $columns);
        $clauses = implode(" $operator ", array_map(fn($k) => "$k = :$k", array_keys($conditions)));
        $orderByString = $orderBy ? " ORDER BY " . implode(", ", $orderBy) : "";
        $sql = "SELECT $columnsString FROM " . static::$table . " WHERE $clauses $orderByString LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        $conditions['limit'] = $limit;
        $conditions['offset'] = $offset;
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

trait TraitCrudDinamic {
    protected static string $table = '';

    // Используем подключение через синглтон
    protected static function db(): PDO {
        return MySQL::getConnection()->getConnection(); // Получаем соединение из синглтона
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

    public static function read(int $id, array $columns = ['*']) {
        $db = static::db();
        $columnsString = implode(',', $columns);
        $sql = "SELECT $columnsString FROM " . static::$table . " WHERE id = :id";
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

    public static function findAll(array $columns = ['*'], array $conditions = [], string $operator = 'AND', array $orderBy = [], int $limit = 10, int $offset = 0) {
        $db = static::db();
        $columnsString = implode(',', $columns);
        $clauses = implode(" $operator ", array_map(fn($k) => "$k = :$k", array_keys($conditions)));
        $orderByString = $orderBy ? " ORDER BY " . implode(", ", $orderBy) : "";
        $sql = "SELECT $columnsString FROM " . static::$table . " WHERE $clauses $orderByString LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        $conditions['limit'] = $limit;
        $conditions['offset'] = $offset;
        $stmt->execute($conditions);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

How to use?
class Product {
    use TraitCrudDinamic;  // Для динамического выбора колонок

    protected static string $table = 'products';  // Название таблицы
}

class Category {
    use TraitCrud;  // Для работы со всеми колонками

    protected static string $table = 'categories';  // Название таблицы
}

// Получаем подключение через синглтон MySQL
$connection = MySQL::getConnection()->getConnection();

// Создание нового продукта
$productId = Product::create([
    'name' => 'Product Name',
    'price' => 100,
    'description' => 'Product Description'
]);

// Чтение продукта
$product = Product::read($productId, ['id', 'name', 'price']);

// Обновление продукта
Product::update($productId, [
    'price' => 120
]);

// Удаление продукта
Product::delete($productId);

// Поиск всех продуктов с фильтрацией
$products = Product::findAll(
    ['id', 'name', 'price'],
    ['status' => 'active'],
    'AND',
    ['price DESC'],
    10,
    0
);

// Получаем подключение через синглтон MySQL
$connection = MySQL::getConnection()->getConnection();

// Создание новой категории
$categoryId = Category::create([
    'name' => 'Category Name'
]);

// Чтение категории
$category = Category::read($categoryId);

// Обновление категории
Category::update($categoryId, [
    'name' => 'Updated Category Name'
]);

// Удаление категории
Category::delete($categoryId);

// Поиск всех категорий с фильтрацией
$categories = Category::findAll(
    ['id', 'name'],
    ['status' => 'active'],
    'AND',
    ['name ASC'],
    10,
    0
);





