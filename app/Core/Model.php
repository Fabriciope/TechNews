<?php

namespace App\Core;

use App\Core\Connection;
use App\Support\Message;

use PDO;
use PDOException;

class Model
{
    /** @var Message|null */
    protected ?Message $message;

    /**  @var object|null */
    protected ?object $data = null;

    /**  @var \PDOException|null */
    protected ?\PDOException $fail = null;

    /**  @var string */
    protected ?string $query;

    /** @var array|null */
    protected ?array $params = null;

    /** @var string|null */
    protected ?string $order = null;

    /** @var string|null */
    protected ?string $limit = null;

    /** @var string|null */
    protected ?string $offset = null;

    /** @var array|nul $protected */
    protected static ?array $protected;

    /** @var array $required */
    protected static array $required;

    public function __construct(
        array $protected,
        array $required
    ) {
        static::$protected = array_merge($protected, ['created-at', 'updated-at']);
        static::$required = $required;
        $this->message = new Message;
    }

    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    public function __get($name)
    {
        return $this->data->$name ?? null;
    }

    public function data(): ?object
    {
        return $this->data;
    }

    protected function fail(): ?\PDOException
    {
        return $this->fail;
    }

    public function message(): Message
    {
        return $this->message;
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = '*'): Model
    {
        if ($terms !== null) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms} ";
            parse_str($params ?? '', $this->params);
            return $this;
        }
        $this->query = "SELECT {$columns} FROM " . static::$entity;
        return $this;
    }

    public function order(string $column, string $order = 'DESC'): Model
    {
        $this->order = " ORDER BY {$column} {$order}";
        return $this;
    }

    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    public function fetch(bool $all = false)
    {
        try {
            $stmt = Connection::getInstance()
                ->prepare($this->query . $this->order . $this->limit . $this->offset);

            // if($this->params) {
            //     foreach($this->params as $key => $value) {
            //         if($key == 'limit' || $key == 'offset' || is_numeric($value)) {
            //             $stmt->bindValue(":{$key}", $value, PDO::PARAM_INT);
            //         } else {
            //             $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
            //         }
            //     }
            // }

            $stmt->execute($this->params);
            $this->params = null;

            if ($stmt->rowCount()) {
                if ($all) {
                    return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
                }
                return $stmt->fetchObject(static::class);
            } else {
                return null;
            }
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    public function count(?string $columns = 'id'): ?int
    {
        try {
            $conn = Connection::getInstance();
            if (!empty($this->query)) {
                $stmt = $conn->prepare($this->query);
                $stmt->execute($this->params);
                return $stmt->rowCount();
            } else {
                $stmt = $conn->query("SELECT {$columns} FROM " . static::$entity);
                return $stmt->rowCount();
            }
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function create(array $data): ?int
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $stmt = Connection::getInstance()
                ->prepare("INSERT INTO " . static::$entity . "({$columns}) VALUES ({$values})");

            $data = $this->filter($data);
            $stmt->execute($this->filter($data));
            return Connection::getInstance()->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function update(array $data, string $terms, string $params): ?int
    {
        try {
            $dataSet = [];
            foreach ($data as $bind => $value) {
                $dataSet[] = "{$bind} = :{$bind}";
            }
            $dataSet = implode(', ', $dataSet);
            parse_str($params, $this->params);

            $stmt = Connection::getInstance()
                ->prepare("UPDATE " . static::$entity . " SET {$dataSet} WHERE {$terms}");

            $dataBind = $this->filter(array_merge($data, $this->params));
            $stmt->execute($dataBind);
            return ($stmt->rowCount() ?? null);
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function delete(string $key, string $value, string $condition = '='): bool
    {
        try {
            $stmt = Connection::getInstance()
                ->prepare("DELETE FROM " . static::$entity . " WHERE {$key} {$condition} :value");
            $stmt->bindValue(":value", $value, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    protected function destroy(): bool
    {
        try {
            $stmt = Connection::getInstance()
                ->prepare("DELETE FROM " . static::$entity . " WHERE id = :id");
            $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }

    protected function safe(): ?array
    {
        $data = (array) $this->data;

        foreach (static::$protected as  $unset) {
            if (isset($data[$unset])) {
                unset($data[$unset]);
            }
        }

        return $data;
    }

    public function filter(array $data): array
    {
        $filter = [];

        foreach ($data as $key => $value) {
            $filter[$key] = is_null($value) ? null : trim(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        return $filter;
    }

    public function required(?string $ignore = null): bool
    {
        $data = (array) $this->data;
        foreach (static::$required as $field) {
            if ($ignore && $field == $ignore) {
                continue;
            }
            if (!isset($data[$field]) || empty($data[$field])) {
                return false;
                break;
            }
        }
        return true;
    }
}
