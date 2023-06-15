<?php

namespace App\Support;

use Nette\Utils\Paginator as NettePaginator;

/**
 * Classe responsável por fazer a paginação
 */
class Paginator
{
    private NettePaginator $paginator;
    private string $uri;
    
    /**
     * __construct
     *
     * @param  int $itemsPerPage
     * @param  int $currentPage
     * @param  string $uri
     * @param  ?int $quantityItems
     * @return void
     */
    public function __construct(int $itemsPerPage,int $currentPage, string $uri, ?int $quantityItems = null)
    {
        $this->paginator = new NettePaginator;
        $this->paginator->setItemCount($quantityItems);
        $this->paginator->setItemsPerPage($itemsPerPage);
        $this->paginator->setpage($currentPage);
        $this->uri = $uri;
    }
    
    /**
     * limit
     *
     * @return int
     */
    public function limit(): int
    {
        return $this->paginator->getLength();
    }
    
    /**
     * offset
     *
     * @return int
     */
    public function offset(): int
    {
        return $this->paginator->getOffset();
    }
    
    /**
     * isFirst
     *
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->paginator->isFirst();
    }
    
    /**
     * isLast
     *
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->paginator->isLast();
    }
    
    /**
     * page
     *
     * @return int
     */
    public function page(): int
    {
        return $this->paginator->getPage();
    }
    
    /**
     * pageCount
     *
     * @return int
     */
    public function pageCount(): int
    {
        return $this->paginator->getPageCount();
    }
    
    /**
     * getUrl
     *
     * @return string
     */
    public function getUrl(): string
    {
        return mb_substr($this->uri, -1) == '/' ? url($this->uri) : url("{$this->uri}/");
    }
    
    /**
     * paginator
     *
     * @return NettePaginator
     */
    public function paginator(): NettePaginator
    {
        return $this->paginator;
    }
}