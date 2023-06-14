<?php

namespace App\Support;

use Nette\Utils\Paginator as NettePaginator;

class Paginator
{
    private NettePaginator $paginator;
    private string $uri;

    public function __construct(int $itemsPerPage,int $currentPage, string $uri, ?int $quantityItems = null)
    {
        $this->paginator = new NettePaginator;
        $this->paginator->setItemCount($quantityItems);
        $this->paginator->setItemsPerPage($itemsPerPage);
        $this->paginator->setpage($currentPage);
        $this->uri = $uri;
    }

    public function limit(): int
    {
        return $this->paginator->getLength();
    }

    public function offset(): int
    {
        return $this->paginator->getOffset();
    }

    public function isFirst(): bool
    {
        return $this->paginator->isFirst();
    }

    public function isLast(): bool
    {
        return $this->paginator->isLast();
    }

    public function page(): int
    {
        return $this->paginator->getPage();
    }

    public function pageCount(): int
    {
        return $this->paginator->getPageCount();
    }

    public function getUrl(): string
    {
        //TODO: verificar se tem uma barra no final ou não e ajustar para uso
        return url($this->uri);
    }

    public function paginator(): NettePaginator
    {
        return $this->paginator;
    }
}