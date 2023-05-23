<?php $this->layout("layouts::profile", ["title" => $title]) ?>

<form action="<?= url("/teste") ?>" method="post">


    <div class="box_input">
        <label for="first_name">Titulo do artigo:</label>
        <input type="text" name="title" class="input" placeholder="Digite o titulo deste artigo...">
    </div>
    <div class="box_input">
        <label for="first_name">Subtitulo do artigo:</label>
        <textarea name="subtitle" class="input" id="" rows="3" placeholder="Digite o subtitulo deste artigo..."></textarea>
    </div>
    <div class="box_select">
        <label for="">Selecione uma categoria:</label>
        <select class="input" name="" id="">
            <option selected value="">Selecione</option>
            <option value="">Programação</option>
            <option value="">Inteligência artificial</option>
            <option value="">Internet das coisas</option>
            <option value="">Hardware</option>
            <option value="">Robótica</option>
            <option value="">Cibersegurança</option>
            <option value="">Aparelhos eletrônicos</option>
        </select>
    </div>
    <div class="box_input_img_article">
        <label for="photo_profile" class="label_input_file">Escolha uma imagem de capa para o artigo:</label>
        <div class="box_file box_input_file_article">
            <input type="file" id="photo_profile">
            <label for="photo_profile">
                <span>Selecione uma capa</span>
                <span>Procurar</span>
            </label>
        </div>
    </div>
    <div class="box_input">
        <label for="first_name">Adicionar link de vídeo:</label>
        <input type="text" name="linkVideo" class="input" placeholder="Copie e cole o link embed do youtube de algum video...">
    </div>

    <div class="container_paragraphs">
        <div class="box_paragraph">
            <div class="box_input">
                <p class="title_paragraph">Parágrafo 1°</p>
                <label for="paragraph1" class="small_label">Titulo deste parágrafo (opcional)</label>
                <input type="text" name="titleParagraph-1" class="input input_title_paragraph" placeholder="Digite o titulo deste parágrafo...">
            </div>
            <div class="box_input box_textarea">
                <textarea name="contentParagraph-1" class="input text_content_paragraph" id="" rows="10" placeholder="Desenvolva o primeiro parágrafo do seu artigo......"></textarea>
            </div>
            <div class="box_actions_paragraph">
                <div class="box_add_paragraph">
                    <span class="btn_add_paragraph text_add_paragraph">Adicionar parágrafo</span>
                    <span class="btn_add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
                </div>
            </div>
        </div>
        <div class="container_other_paragraphs">

        </div>
    </div>

    <button type="submit" class="btn_green btn_new_article">Salvar</button>

</form>