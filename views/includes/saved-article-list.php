<div class="box_saved_article">
        <div class="box_info_saved_article">
            <div class="box_img_saved_article">
                <img src="<?=image($article->cover)?>" alt="">
            </div>
            <div class="info_article_saved">
                <h4><?=$this->e($article->title)?></h4>
                <p><?=date_fmt($article->created_at)?></p>
            </div>
        </div>
        <div class="box_actions_saved">
            <form action="/TechNews/teste" method="post">
                <button class="btn_action_saved publish" name="article" value="id=2">Publicar</button>
            </form>
            <a class="btn_action_saved edit" href="">Editar</a>
            <form action="">
                <button class="btn_action_saved delete" name="article" value="id=2">Deletar</button>
            </form>
        </div>
    </div>