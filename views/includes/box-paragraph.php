<div class="box_paragraph">
    <div class="box_input">
        <p class="title_paragraph">Parágrafo <?=$paragraph->position ?? '1'?>°</p>
        <label for="paragraph<?=$paragraph->position ?? '1'?>" class="small_label">Titulo deste parágrafo (opcional)</label>
        <input 
            type="text" 
            name="titleParagraph-<?=$paragraph->position ?? '1'?>" 
            class="input input_title_paragraph" 
            placeholder="Digite o titulo deste parágrafo..."
            value="<?=text($paragraph->title ?? '')?>">
    </div>
    <div class="box_input box_textarea">
        <textarea 
            name="contentParagraph-<?=$paragraph->position ?? '1'?>" 
            class="input text_content_paragraph" 
            id="" 
            rows="10" 
            placeholder="Desenvolva o primeiro parágrafo do seu artigo..."
            ><?= text($paragraph->paragraph ?? '')?></textarea>
    </div>
    <div class="box_actions_paragraph <?= !$first ? 'new_box_paragraph' : '' ?>">
        <?php if (!$first) : ?>
            <div class="box_remove_paragraph">
                <span class="icon_remove_paragraph btn_remove_paragraph">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <span class="text_remove_paragraph btn_remove_paragraph">
                    Remover parágrafo
                </span>
            </div>
        <?php endif; ?>
        <div class="box_add_paragraph">
            <span class="btn_add_paragraph text_add_paragraph">
                Adicionar parágrafo
            </span>
            <span class="btn_add_paragraph icon_add_paragraph">
                <i class="fa-solid fa-file-circle-plus"></i>
            </span>
        </div>
    </div>
</div>