<?php

namespace App\Core;

use App\Core\Connection;
use App\Support\Message;

use PDO;
use PDOException;

abstract class Model
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
        static::$protected = array_merge($protected, ['created_at', 'updated_at']);
        static::$required = $required;
        $this->message = new Message;
    }
    
    /**
     * __set
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }
    
    /**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data->$name ?? null;
    }
    
    /**
     * data
     *
     * @return object
     */
    public function data(): ?object
    {
        return $this->data;
    }
    
    /**
     * fail
     *
     * @return PDOException
     */
    protected function fail(): ?\PDOException
    {
        return $this->fail;
    }
    
    /**
     * message
     *
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
    
    /**
     * find
     *
     * @param  ?string $terms
     * @param  ?string $params
     * @param  string $columns
     * @return Model
     */
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
    
    /**
     * order
     *
     * @param  string $column
     * @param  string $order
     * @return Model
     */
    public function order(string $column, string $order = 'DESC'): Model
    {
        $this->order = " ORDER BY {$column} {$order}";
        return $this;
    }
    
    /**
     * limit
     *
     * @param  int $limit
     * @return Model
     */
    public function limit(int $limit): Model
    {
        $this->limit = " LIMIT {$limit}";
        return $this;
    }
    
    /**
     * offset
     *
     * @param  int $offset
     * @return Model
     */
    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }
    
    
    public final function fetch(bool $all = false)
    {
        try {
            $stmt = Connection::getInstance()
                ->prepare($this->query . $this->order . $this->limit . $this->offset);

            $stmt->execute($this->params);

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
    
    /**
     * count
     *
     * @param  string $columns
     * @return ?int
     */
    public function count(string $columns = 'id'): ?int
    {
        try {
            $conn = Connection::getInstance();
            if (!empty($this->query)) {
                $stmt = $conn->prepare($this->query);
                $stmt->execute($this->params);
                return $stmt->rowCount();
            } else {
                $stmt = $conn->query("SELECT COUNT({$columns}) FROM " . static::$entity);
                return $stmt->fetchColumn();
            }
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }
    
    /**
     * create
     *
     * @param  array $data
     * @return int
     */
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
    
    /**
     * update
     *
     * @param  array $data
     * @param  string $terms
     * @param  string $params
     * @return int
     */
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
    
    /**
     * delete
     *
     * @param  string $key
     * @param  string $value
     * @param  string $condition
     * @return bool
     */
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
    
    /**
     * destroy
     *
     * @return bool
     */
    public function destroy(): bool
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
    
    /**
     * safe
     *
     * @return ?array
     */
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
    
    /**
     * filter
     *
     * @param  mixed $data
     * @return array
     */
    public function filter(array $data): array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = is_null($value) ? null : trim(filter_var($value));
        }

        return $filter;
    }
    
    /**
     * required
     *
     * @param  ?string $ignore
     * @return bool
     */
    public function required(?string $ignore = null): bool
    {
        $data = (array) $this->data;
        foreach (static::$required as $field) {
            if ($ignore && $field == $ignore) continue;
        
            if (!isset($data[$field]) || empty($data[$field])) {
                return false;
                break;
            }
        }
        return true;
    }
    
    /**
     * validateFields
     *
     * @return bool
     */
    abstract protected function validateFields(): bool;
}
