<?php


namespace app;

use PDO;
use app\models\Product;

class Database
{
    private PDO $pdo;


    public static Database $db;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'phpmyadmin', 'phpmyadmin');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }

    public function getProducts($search = '')
    {
        if ($search) {
            $statement = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY CREATE_DATE DESC');
            $statement->bindValue(':title', "%$search%");

        } else {
            // select products
            $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY CREATE_DATE DESC');
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getProductById($id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();
        return $statement->fetch();
    }

    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                    VALUES (:title, :image, :description, :price, :date) ");

        $statement->bindValue(':title', $product->getTitle());
        $statement->bindValue(':image', $product->getImagePath());
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':price', $product->getPrice());
        $statement->bindValue(':date', date("Y-m-d H:i:s"));
        $statement->execute();
    }

    public function updateProduct(Product $product)
    {
        $statement = $this->getPdo()->prepare("UPDATE products SET title = :title,
                                                              image = :image,
                                                              description = :description,
                                                              price = :price
                                           WHERE id = :id");


        $statement->bindValue(':title', $product->getTitle());
        $statement->bindValue(':image', $product->getImagePath());
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':price', $product->getPrice());
        $statement->bindValue(':id', $product->getId());
        $statement->execute();
    }


    public function deleteProduct($id)
    {

        $statement = $this->getPdo()->prepare("DELETE FROM products WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();

    }

        /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }


}