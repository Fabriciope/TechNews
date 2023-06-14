<?php if (!$paginator->isFirst()) : ?>
    <a class="page_action" href="<?= $paginator->getUrl() . '1' ?>">Primeira</a>
    <a href="<?= $paginator->getUrl() . $paginator->page() - 1 ?>">
        <i class="fa-solid fa-angles-left"></i>
    </a>
<?php endif; ?>

<?= "<span> Página {$paginator->page()} de {$paginator->pageCount()} </span>" ?>

<?php if (!$paginator->isLast()) : ?>
    <a href="<?= $paginator->getUrl() . $paginator->page() + 1 ?>">
        <i class="fa-solid fa-angles-right"></i>
    </a>
    <a class="page_action" href="<?= $paginator->getUrl() . $paginator->pageCount() ?>">Última</a>
<?php endif; ?>