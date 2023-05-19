<?php $this->layout("layouts::profile", ["title" => $title]) ?>

<form action="#">
    <div class="content_form_new_article">
        <div class="box_content_new_profile_left">
            <div class="box_input">
                <label for="first_name">Titulo do artigo:</label>
                <input type="text" class="input" placeholder="Digite o titulo deste artigo...">
            </div>
            <div class="box_input">
                <label for="first_name">Subtitulo do artigo:</label>
                <textarea name="" class="input" id="" rows="3" placeholder="Digite o subtitulo deste artigo..."></textarea>
            </div>
            <div class="box_input">
                <label for="first_name">Adicionar link de vídeo:</label>
                <input type="text" class="input" placeholder="Copie e cole o link embed do youtube de algum video...">
            </div>

            <div class="container_paragraphs">
                <div class="box_paragraph">
                    <div class="box_input">
                        <label for="first_name">1° paragrafo:</label>
                        <textarea name="" class="input" id="" rows="10" placeholder="Desenvolva o primeiro paragrafo do seu artigo......"></textarea>
                    </div>
                    <div class="box_actions_paragraph">
                        <div class="box_remove_paragraph">
                            <span class="icon_remove_paragraph">
                                <i class="fa-solid fa-trash-can"></i>
                            </span>
                            <span class="text_remove_paragraph">
                                Remover paragrafo
                            </span>
                        </div>
                        <div class="box_add_paragraph">
                            <span class="add_paragraph text_add_paragraph">Adicionar paragrafo</span>
                            <span class="add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>