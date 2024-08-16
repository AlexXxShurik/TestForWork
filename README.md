Функции PHP для тестового задания.

Вставьте требуемую часть кода после функции, которые находятся в репозитории.
В комментария расписано назначение.

// Создание таблицы для iPhones
$iphonesColumns = [
    'id INT PRIMARY KEY',
    'name VARCHAR(255)',
    'price DECIMAL(10, 2)',
    'description TEXT'
];
createTable('iphones', $iphonesColumns);

// Получение и сохранение iPhones
getAndSaveIphones();

// Создание и вставка данных для других таблиц
// Recipes
$recipesColumns = [
    'id INT PRIMARY KEY',
    'name VARCHAR(255)',
    'ingredients TEXT',
    'instructions TEXT'
];
createTable('recipes', $recipesColumns);
$recipes = fetchDataFromApi('recipes');
insertData('recipes', $recipes['recipes'], ['id', 'name', 'ingredients', 'instructions']);

// Posts
$postsColumns = [
    'id INT PRIMARY KEY',
    'title VARCHAR(255)',
    'content TEXT',
    'author VARCHAR(255)',
    'created_at DATETIME'
];
createTable('posts', $postsColumns);
$posts = fetchDataFromApi('posts');
insertData('posts', $posts['posts'], ['id', 'title', 'content', 'author', 'created_at']);

// Users
$usersColumns = [
    'id INT PRIMARY KEY',
    'name VARCHAR(255)',
    'email VARCHAR(255)',
    'role VARCHAR(255)',
    'created_at DATETIME'
];
createTable('users', $usersColumns);
$users = fetchDataFromApi('users');
insertData('users', $users['users'], ['id', 'name', 'email', 'role', 'created_at']);
