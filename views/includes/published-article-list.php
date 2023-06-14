<article class="article_post_published">
    <a class="link_img_post_published" href="<?=url("/artigo/{$article->uri}")?>">
        <img src="<?= image($article->cover) ?>" alt="">
    </a>
    <div class="box_info_post_published">
        <p class="info_post"> <a href="<?=$article->category()->uri?>"><?=$article->category()->category?></a> <span> <?= date_fmt($article->published_at) ?></span></p>
        <h4 class="title_post"><a href="<?=url("/artigos/{$article->uri}")?>"><?= text($article->title) ?></a></h4>
    </div>
    <div class="box_comment_published">
        <i class="fa-regular fa-message"></i>
        <span><?=$article->amountOfComments()?></span>
    </div>
</article>