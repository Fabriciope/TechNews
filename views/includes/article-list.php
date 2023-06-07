<article class="article_post">
    <a class="link_img_post" href="<?=url("artigo/{$article->uri}")?>">
        <img src="<?= image($article->cover) ?>" alt="capa do artigo">
    </a>
    <div class="box_info_post">
        <p class="info_post"> 
            <span> <a href="<?=url("/artigos/categoria/{$article->category('uri')}")?>"><?=$article->category('category')?></a> &bull;
             <a href="<?=url("/usuario/{$article->author('id')}")?>"><?=$article->author('first_name')?></a> </span> 
             <span><?=date_fmt($article->published_at, 'd/m/Y')?></span>
        </p>
        <h4 class="title_post"><a href="<?=url("artigo/{$article->uri}")?>"><?=text($article->title)?></a></h4>
        <p class="subtitle_post"><a href="<?=url("artigo/{$article->uri}")?>"><?=str_limit_chars($article->subtitle, 100)?></a></p>
    </div>
    <div class="box_comment">
        <i class="fa-regular fa-message"></i>
        <span>
            27
        </span>
    </div>
</article>