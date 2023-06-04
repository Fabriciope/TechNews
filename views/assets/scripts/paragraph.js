const containerOtherParagraphs = document.querySelector(".container_paragraphs");

let paragraphs = document.querySelectorAll(".container_paragraphs .box_paragraph");

let currentParagraph = paragraphs.length;

start();

function start() {
    addActionButtons()
}

function addNewParagraph() {
    currentParagraph++;
    
    removeActionButtons();
    createBoxNewParagraph();
}

function removeActionButtons() {

    let boxAdd = document.querySelector(".box_add_paragraph");
    if(boxAdd) {
        boxAdd.remove();
    }

    // let boxRemoveParagraph = document.querySelector(".box_remove_paragraph");
    // if(boxRemoveParagraph) {
    //     boxRemoveParagraph.remove();
    // }
}

function createBoxNewParagraph() {
    let boxParagraph = document.createElement("div");
    boxParagraph.classList.add("box_paragraph");
    boxParagraph.innerHTML = `
        <div class="box_input">
            <p class="title_paragraph">Parágrafo ${currentParagraph}°</p>
            <label for="paragraph${currentParagraph}" class="small_label">Titulo deste parágrafo (opcional)</label>
            <input type="text" name="titleParagraph-${currentParagraph}" class="input input_title_paragraph" placeholder="DIgite o titulo deste parágrafo...">
        </div>
        <div class="box_input box_textarea">
            <textarea name="contentParagraph-${currentParagraph}" class="input text_content_paragraph" id="" rows="10" placeholder="Desenvolva o primeiro parágrafo do seu artigo......"></textarea>
        </div>
        <div class="box_actions_paragraph new_box_paragraph">
            <div class="box_remove_paragraph">
                <span class="icon_remove_paragraph btn_remove_paragraph">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <span class="text_remove_paragraph btn_remove_paragraph">
                    Remover parágrafo
                </span>
            </div>
            <div class="box_add_paragraph">
                <span class="btn_add_paragraph text_add_paragraph">Adicionar parágrafo</span>
                <span class="btn_add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
            </div>
        </div>
    `;

    containerOtherParagraphs.appendChild(boxParagraph);
    addActionButtons();
    updateParagraphs();
}

function removeBoxParagraph() {
    currentParagraph--;

    let boxParagraphRemove = this.closest(".box_paragraph");
    boxParagraphRemove.remove();

    reorderParagraphs();


    let lastParagraph = paragraphs[paragraphs.length -1];

    let boxActionsLastParagraph = lastParagraph.querySelector(".box_actions_paragraph");
    boxActionsLastParagraph.remove();


    let boxActionsParagraph = document.createElement("div");

    if(paragraphs.length >= 2) {
        boxActionsParagraph.classList.add("box_actions_paragraph", "new_box_paragraph");
        boxActionsParagraph.innerHTML = `
        <div class="box_remove_paragraph">
            <span class="icon_remove_paragraph btn_remove_paragraph">
                <i class="fa-solid fa-trash-can"></i>
            </span>
            <span class="text_remove_paragraph btn_remove_paragraph">
                Remover parágrafo
            </span>
        </div>
        <div class="box_add_paragraph">
            <span class="btn_add_paragraph text_add_paragraph">Adicionar parágrafo</span>
            <span class="btn_add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `;
    } else {
        boxActionsParagraph.classList.add("box_actions_paragraph");
        boxActionsParagraph.innerHTML = `
        <div class="box_add_paragraph">
            <span class="btn_add_paragraph text_add_paragraph">Adicionar parágrafo</span>
            <span class="btn_add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `;
    }
    lastParagraph.appendChild(boxActionsParagraph);
    addActionButtons();


}

function addActionButtons() {
    let buttonsRemoveParagraph = document.querySelectorAll(".btn_remove_paragraph");
    if(buttonsRemoveParagraph) {
        buttonsRemoveParagraph.forEach(button => {
            button.addEventListener("click", removeBoxParagraph);
            console.log()
        }); 
    }
    
    let buttonsAddParagraph = document.querySelectorAll(".btn_add_paragraph");
    if(buttonsAddParagraph) {
        buttonsAddParagraph.forEach(button=> {
            button.addEventListener("click", addNewParagraph);
        });
    }
}

function reorderParagraphs() {
    updateParagraphs();
    paragraphs.forEach(( paragraph, indexCurrentParagraph)=> {
        indexCurrentParagraph++;
        let pTitleParagraph = paragraph.querySelector(".title_paragraph");
        pTitleParagraph.innerText = `Parágrafo ${indexCurrentParagraph}°`;

        let labelInfo = paragraph.querySelector(".small_label");
        labelInfo.for = `paragraph${indexCurrentParagraph}`;

        let inputTitle = paragraph.querySelector(".input_title_paragraph");
        inputTitle.setAttribute("name", `titleParagraph-${indexCurrentParagraph}`);

        let textareaParagraph = paragraph.querySelector(".text_content_paragraph");
        textareaParagraph.setAttribute("name", `contentParagraph-${indexCurrentParagraph}`);

    });
}

function updateParagraphs() {
    paragraphs = document.querySelectorAll(".container_paragraphs .box_paragraph");
}