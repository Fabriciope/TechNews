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
    )
    {
        static::$protected = array_merge($protected, ['created-at', 'updated-at']);
        static::$required = $required;
        $this->message = new Message;
    }

    public function __set($name, $value)
    {
        if(empty($this->data)) {
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

    public function message(): ?Message
    {
        return $this->message;
    }

    public function find(?string $terms = null, ?string $params = null, string $columns = '*'): Model
    {
        if($terms !== null) {
            $this->query = "SELECT {$columns} FROM " . static::$entity . " WHERE {$terms}";
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
                    ->prepare($this->query . $this->limit . $this->offset . $this->order);
            $stmt->execute($this->params);

            if($stmt->rowCount()) {
                if($all) {
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

    public function count(): ?int
    {
        if(!empty($this->query)) {
            try {
                $stmt = Connection::getInstance()
                        ->prepare($this->query);
                $stmt->execute($this->params);
            } catch (PDOException $exception) {
                $this->fail = $exception;
                return null;
            }
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
            $stmt->execute($data);
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
            foreach($data as $bind => $value) {
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
            var_dump($exception);
        }
    }

    protected function safe(): ?array
    {
        $data = (array) $this->data;

        foreach(static::$protected as  $unset) {
            if(isset($data[$unset])) {
                unset($data[$unset]);
            }
        }

        return $data;
    }

    public function filter(array $data): array
    {
        $filter = [];

        foreach($data as $key => $value) {
            $filter[$key] = is_null($value) ? null : trim(filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        return $filter;
    }

    public function required(?string $ignore = null):bool
    {
        $data = (array) $this->data;
        foreach(static::$required as $field) {
            if($ignore && $field == $ignore) {
                continue;
            }
            if(!isset($data[$field]) || empty($data[$field])) {
                return false;
                break;
            }
        }
        return true;
    }
}