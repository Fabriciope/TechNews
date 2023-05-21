const btnMenu=document.querySelector(".btn_menu");const btnCloseMenu=document.querySelector(".btn_menu_mobile_active");function toggleMenu(){document.body.classList.toggle("menu_active")}
btnMenu.onclick=toggleMenu;btnCloseMenu.onclick=toggleMenu;const liDropDown=document.querySelector(".li_profile");function toggleActionsProfile(){this.classList.toggle("active_dropdown")}
liDropDown.onclick=toggleActionsProfile;let boxAddParagraphDefault=document.querySelector(".box_add_paragraph");const containerOtherParagraphs=document.querySelector(".container_other_paragraphs");let currentParagraph=1;boxAddParagraphDefault.onclick=function(){this.style.display="none";addNewParagraph()}
function addNewParagraph(){currentParagraph++;removeActionButtons();createBoxNewParagraph()}
function createBoxNewParagraph(){let boxParagraph=document.createElement("div");boxParagraph.classList.add("box_paragraph");boxParagraph.innerHTML=`
        <div class="box_input">
            <p class="title_paragraph">Parágrafo ${currentParagraph}°</p>
            <label for="paragraph${currentParagraph}" class="small_label">Titulo deste parágrafo (opcional)</label>
            <input type="text" name="titleParagraph${currentParagraph}" class="input" placeholder="DIgite o titulo deste parágrafo...">
        </div>
        <div class="box_input box_textarea">
            <textarea name="contentParagraph${currentParagraph}" class="input" id="" rows="10" placeholder="Desenvolva o primeiro parágrafo do seu artigo......"></textarea>
        </div>
        <div class="box_actions_paragraph new_box_paragraph">
            <div class="box_remove_paragraph">
                <span class="icon_remove_paragraph">
                    <i class="fa-solid fa-trash-can"></i>
                </span>
                <span class="text_remove_paragraph">
                    Remover parágrafo
                </span>
            </div>
            <div class="box_add_paragraph_new">
                <span class="text_add_paragraph">Adicionar parágrafo</span>
                <span class="icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
            </div>
        </div>
    `;containerOtherParagraphs.appendChild(boxParagraph);addActionButtons()}
function removeBoxParagraph(){currentParagraph--;let boxParagraphRemove=this.parentElement.parentElement;boxParagraphRemove.remove();let paragraphs=document.querySelectorAll(".container_other_paragraphs .box_paragraph");let lastParagraph=paragraphs[paragraphs.length-1];let boxActionsParagraph=document.createElement("div");if(paragraphs.length>=1){boxActionsParagraph.classList.add("box_actions_paragraph","new_box_paragraph");boxActionsParagraph.innerHTML=`
        <div class="box_remove_paragraph">
            <span class="icon_remove_paragraph">
                <i class="fa-solid fa-trash-can"></i>
            </span>
            <span class="text_remove_paragraph">
                Remover parágrafo
            </span>
        </div>
        <div class="box_add_paragraph_new">
            <span class="text_add_paragraph">Adicionar parágrafo</span>
            <span class="icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `;lastParagraph.appendChild(boxActionsParagraph);addActionButtons()}else{boxAddParagraphDefault.style.display="block"}}
function removeActionButtons(){let boxAdd=document.querySelector(".box_add_paragraph_new");if(boxAdd){boxAdd.remove()}
let boxRemoveParagraph=document.querySelector(".box_remove_paragraph");if(boxRemoveParagraph){boxRemoveParagraph.remove()}}
function addActionButtons(){let boxRemoveParagraph=document.querySelector(".box_remove_paragraph");boxRemoveParagraph.addEventListener("click",removeBoxParagraph);let newBoxAdd=document.querySelector(".box_add_paragraph_new");newBoxAdd.addEventListener("click",addNewParagraph)}