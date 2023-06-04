<?php $this->layout("layouts::profile", ['title' => $title, 'userData' => $userData]) ?>

<form class="formAjax" action="<?= url("/perfil/artigo/{$formAction}") ?>" method="POST" enctype="multipart/form-data">

    <?= csrf_input() ?>

    <?= isset($articleData) ? "<input type='hidden' name='articleUri' value='{$articleData->uri}'>" : ''?>

    <div class="box_input">
        <label for="title">Titulo do artigo:</label>
        <input 
            type="text" 
            name="title" 
            class="input" 
            id="title"
            placeholder="Digite o titulo deste artigo..."
            value="<?= $articleData->title ?? ''?>">
    </div>
    <div class="box_input">
        <label for="subtitle">Subtitulo do artigo:</label>
        <textarea 
            name="subtitle" 
            class="input" 
            id="subtitle" 
            rows="3" 
            placeholder="Digite o subtitulo deste artigo..."
        ><?= $articleData->subtitle ?? ''?></textarea>
    </div>
    <div class="box_select">
        <label for="category">Selecione uma categoria:</label>
        <select class="input" name="category" id="category">
            <option selected value="">Selecione</option>
            <?php foreach($categoryOptions as $category): ?>
                <option value="<?=$category->id?>" <?=$category->selected ?? ''?> ><?=$category->category?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="box_input_img_article">
        <label for="photo_profile" class="label_input_file">Escolha uma imagem de capa para o artigo:</label>
        <div class="box_file box_input_file_article">
            <input class="input_file" type="file" name="cover" id="photo_profile">
            <label for="photo_profile">
                <span class="file_name">Selecione uma capa</span>
                <span>Procurar</span>
            </label>
        </div>
    </div>
    <div class="box_input">
        <label for="first_name">Adicionar link de vídeo:</label>
        <input 
            type="text" 
            name="linkVideo" 
            class="input" 
            placeholder="Copie e cole o link embed do YouTube de algum video..."
            value="<?= $formAction == 'alterar' ? convertToYouTubeUrl($articleData->video) : ''?>">
    </div>

    <div class="container_paragraphs">
        <?php if(isset($articlesParagraphs)): ?>
            <?php foreach($articlesParagraphs as $key => $paragraph): ?>
                <?php if($key == 0): ?>
                    <?php $this->insert('includes::box-paragraph', [
                        'first' =>  true,
                        'paragraph' => $paragraph
                    ]); ?>
                <?php else: ?>
                    <div class="container_other_paragraphs">
                        <?php $this->insert('includes::box-paragraph', [
                            'first' => false,
                            'paragraph' => $paragraph
                        ]); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <?= $this->insert('includes::box-paragraph', ['first' => true]) ?>
            <div class="container_other_paragraphs"></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn_green btn_new_article">
        <?=isset($articleData) ? 'Salvar alteração' : 'Criar artigo' ?>
    </button>
</form>