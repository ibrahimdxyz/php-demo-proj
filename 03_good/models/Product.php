<?php


namespace app\models;


use app\Database;
use app\helpers\UtilHelpers;

class Product
{

    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $imagePath = null;
    private ?float $price = null;
    private ?array $imageFile = null;


    /**
     * @param $data
     */
    public function load($data)
    {
        $this->setId($data['id'] ?? null);
        $this->setTitle($data['title']);
        $this->setDescription($data['description'] ?? null);
        $this->setPrice($data['price']);
        $this->setImageFile($data['imageFile'] ?? null);
        $this->setImagePath($data['imagePath'] ?? null);
    }


    /**
     * @return array
     */
    public function save() {
        $errors = [];
        if (!$this->getTitle()) {
            $errors[] = "Title doesn't exist";
        }
        if (!$this->getPrice()) {
            $errors[] = "Price doesn't exist";
        }


        if (!is_dir(__DIR__.'/../public/images')) {
            mkdir(__DIR__.'/../public/images');
        }

        if (empty($errors)) {

            if ($this->getImageFile() && $this->getImageFile()['tmp_name']) {

                if ($this->getImagePath()) {
                    unlink(__DIR__ . '/../public/' . $this->getImagePath());
                }

                $this->setImagePath('images/' . UtilHelpers::randomString(8) . '/' . $this->getImageFile()['name']);
                mkdir(dirname(__DIR__ . '/../public/' . $this->getImagePath()));
                move_uploaded_file($this->getImageFile()['tmp_name'], __DIR__ . '/../public/' . $this->getImagePath());
            }


            $db = Database::$db;
            if ($this->getId()) {
                $db->updateProduct($this);
            }
            else
            {
                $db->createProduct($this);
            }


        }

        return $errors;
    }


    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string|null $imagePath
     */
    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @param float|null $Price
     */
    public function setPrice(?float $Price): void
    {
        $this->price = $Price;
    }

    /**
     * @param array|null $imageFile
     */
    public function setImageFile(?array $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return array|null
     */
    public function getImageFile(): ?array
    {
        return $this->imageFile;
    }

}