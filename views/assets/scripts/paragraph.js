let btnAddParagraph = document.querySelectorAll(".box_add_paragraph");
const containerParagraphs = document.querySelector(".container_paragraphs");

let btnRemoveParagraph = [];

let currentParagraph = 1;

btnAddParagraph.forEach(btn => {
    btn.addEventListener("click", addNewParagraph);
});


function addNewParagraph() {
    currentParagraph++;
    
    removeActionButtons();
    createBoxNewParagraph();
}


function createBoxNewParagraph() {
    let boxParagraph = document.createElement("div");
    boxParagraph.classList.add("box_paragraph");
    boxParagraph.innerHTML = `
        <div class="box_input">
            <p class="title_paragraph">Paragrafo ${currentParagraph}°</p>
            <label for="paragraph${currentParagraph}" class="small_label">Titulo deste paragrafo (opcional)</label>
            <input type="text" name="titleParagraph${currentParagraph}" class="input" placeholder="DIgite o titulo deste paragrafo...">
        </div>
        <div class="box_input">
            <textarea name="contentParagraph${currentParagraph}" class="input" id="" rows="10" placeholder="Desenvolva o primeiro paragrafo do seu artigo......"></textarea>
        </div>
        <div class="box_actions_paragraph new_box_paragraph">
            <div class="box_remove_paragraph">
                <span class="icon_remove_paragraph">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <span class="text_remove_paragraph">
                    Remover paragrafo
                </span>
            </div>
            <div class="box_add_paragraph">
                <span class="text_add_paragraph">Adicionar paragrafo</span>
                <span class="icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
            </div>
        </div>
    `;

    containerParagraphs.appendChild(boxParagraph);
    addActionButtons();
}

function removeBoxParagraph() {
    currentParagraph--;
    let boxParagraphRemove = this.parentElement.parentElement;
    boxParagraphRemove.remove();

    let paragraphs = document.querySelectorAll(".box_paragraph");
    let lastParagraph = paragraphs[paragraphs.length -1];


    let boxActionsParagraph = document.createElement("div");

    if(paragraphs.length >= 2) {
        boxActionsParagraph.classList.add("box_actions_paragraph", "new_box_paragraph");
        boxActionsParagraph.innerHTML = `
        <div class="box_remove_paragraph">
            <span class="icon_remove_paragraph">
                <i class="fa-solid fa-trash-can"></i>
            </span>
            <span class="text_remove_paragraph">
                Remover paragrafo
            </span>
        </div>
        <div class="box_add_paragraph">
            <span class="text_add_paragraph">Adicionar paragrafo</span>
            <span class="icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `;
    } else {
        boxActionsParagraph.classList.add("box_actions_paragraph");
        boxActionsParagraph.innerHTML = `
        <div class="box_add_paragraph">
            <span class="text_add_paragraph">Adicionar paragrafo</span>
            <span class="icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `;
    }

    lastParagraph.appendChild(boxActionsParagraph);

    addActionButtons();
}

function removeActionButtons() {
    btnAddParagraph.forEach(boxAdd => {
        boxAdd.remove();
    })
    btnAddParagraph = document.querySelectorAll(".box_add_paragraph");

    btnRemoveParagraph.forEach(btn=> {
        btn.remove();
    });
    btnRemoveParagraph = document.querySelectorAll(".box_remove_paragraph");
}

function addActionButtons() {
    btnRemoveParagraph = document.querySelectorAll(".box_remove_paragraph");
    btnRemoveParagraph.forEach(btn=> {
        btn.addEventListener("click", removeBoxParagraph);
    });
    
    btnAddParagraph = document.querySelectorAll(".box_add_paragraph");
    btnAddParagraph.forEach(btn => {
        btn.addEventListener("click", addNewParagraph);
    });
}