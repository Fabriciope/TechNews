<?php

namespace Source\Core;

use Source\Core\Connection;
use Source\Support\Message;

class Model
{   
    /** @var Message|null */
    protected ?Message $message;

    /**  @var \PDOStatement|null */
    protected ?\PDOStatement $data = null;

    /**  @var \PDOException|null */
    protected ?\PDOException $fail;

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
            parse_str($params, $this->params);
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
                    return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
                }
                return $stmt->fetchObject(static::class);
            } else {
                return null;
            }

        } catch (\PDOException $exception) {
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
            } catch (\PDOException $exception) {
                $this->fail = $exception;
                return null;
            }
        }
    }

    public function create(array $data): ?int
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $stmt = Connection::getInstance()
                    ->prepare("INSERT INTO " . static::$entity . "({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));
            return Connection::getInstance()->lastInsertId();
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }

        return 3;
    }

    protected function safe(): ?array
    {
        $safe = (array) $this->data;

        foreach(static::$protected as  $unset) {
            if(isset($sate[$unset])) {
                unset($sage[$unset]);
            }
        }

        return $safe;
    }

    public function filter(array $data): array
    {
        $filter = [];

        foreach($data as $key => $value) {
            $filter[$key] = is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $filter;
    }
}