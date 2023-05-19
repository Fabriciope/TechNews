<?php $this->layout("layouts::profile", ["title" => $title]) ?>

<form action="<?=url("/teste")?>" method="post">
    <div class="content_form_new_article">
        <div class="box_content_new_profile_left">
            <div class="box_input">
                <label for="first_name">Titulo do artigo:</label>
                <input type="text" name="title" class="input" placeholder="Digite o titulo deste artigo...">
            </div>
            <div class="box_input">
                <label for="first_name">Subtitulo do artigo:</label>
                <textarea name="subtitle" class="input" id="" rows="3" placeholder="Digite o subtitulo deste artigo..."></textarea>
            </div>
            <div class="box_input">
                <label for="first_name">Adicionar link de vídeo:</label>
                <input type="text" name="linkVideo" class="input" placeholder="Copie e cole o link embed do youtube de algum video...">
            </div>

            <div class="container_paragraphs">
                <div class="box_paragraph">
                    <div class="box_input">
                        <p class="title_paragraph">Paragrafo 1°</p>
                        <label for="paragraph1" class="small_label">Titulo deste paragrafo (opcional)</label>
                        <input type="text" name="titleParagraph1" class="input" placeholder="DIgite o titulo deste paragrafo...">
                    </div>
                    <div class="box_input">
                        <textarea name="contentParagraph1" class="input" id="" rows="10" placeholder="Desenvolva o primeiro paragrafo do seu artigo......"></textarea>
                    </div>
                    <div class="box_actions_paragraph">
                        <div class="box_add_paragraph">
                            <span class="add_paragraph text_add_paragraph">Adicionar paragrafo</span>
                            <span class="add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit">enviar</button>
    </div>
</form>