Object.values(document.forms).forEach(form=>{if(form.classList.contains('formAjax')){form.addEventListener('submit',async(event)=>{event.preventDefault();const formData=new FormData(form);console.log(form.method)
try{fetch(form.action,{method:'POST',headers:{'Content-Type':'application/json'},body:formData}).then(data=>{data.json()}).then(response=>{if(response.redirect){location.href=response.redirect}
if(response.message){let boxResponse=document.querySelector('.ajax_response');boxResponse.innerHTML=response.message}})}catch(error){console.log(error)}})}});const btnMenu=document.querySelector(".btn_menu");const btnCloseMenu=document.querySelector(".btn_menu_mobile_active");function toggleMenu(){document.body.classList.toggle("menu_active")}
btnMenu.onclick=toggleMenu;btnCloseMenu.onclick=toggleMenu;const liDropDown=document.querySelector(".li_profile");function toggleActionsProfile(){this.classList.toggle("active_dropdown")}
if(liDropDown){liDropDown.onclick=toggleActionsProfile};const containerOtherParagraphs=document.querySelector(".container_paragraphs");let paragraphs=document.querySelectorAll(".container_paragraphs .box_paragraph");let currentParagraph=1;start();function start(){addActionButtons()}
function addNewParagraph(){currentParagraph++;removeActionButtons();createBoxNewParagraph()}
function removeActionButtons(){let boxAdd=document.querySelector(".box_add_paragraph");if(boxAdd){boxAdd.remove()}}
function createBoxNewParagraph(){let boxParagraph=document.createElement("div");boxParagraph.classList.add("box_paragraph");boxParagraph.innerHTML=`
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
    `;containerOtherParagraphs.appendChild(boxParagraph);addActionButtons();updateParagraphs()}
function removeBoxParagraph(){currentParagraph--;let boxParagraphRemove=this.closest(".box_paragraph");boxParagraphRemove.remove();reorderParagraphs();let lastParagraph=paragraphs[paragraphs.length-1];let boxActionsLastParagraph=lastParagraph.querySelector(".box_actions_paragraph");boxActionsLastParagraph.remove();let boxActionsParagraph=document.createElement("div");if(paragraphs.length>=2){boxActionsParagraph.classList.add("box_actions_paragraph","new_box_paragraph");boxActionsParagraph.innerHTML=`
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
        `}else{boxActionsParagraph.classList.add("box_actions_paragraph");boxActionsParagraph.innerHTML=`
        <div class="box_add_paragraph">
            <span class="btn_add_paragraph text_add_paragraph">Adicionar parágrafo</span>
            <span class="btn_add_paragraph icon_add_paragraph"><i class="fa-solid fa-file-circle-plus"></i></span>
        </div>
        `}
lastParagraph.appendChild(boxActionsParagraph);addActionButtons()}
function addActionButtons(){let buttonsRemoveParagraph=document.querySelectorAll(".btn_remove_paragraph");if(buttonsRemoveParagraph){buttonsRemoveParagraph.forEach(button=>{button.addEventListener("click",removeBoxParagraph);console.log()})}
let buttonsAddParagraph=document.querySelectorAll(".btn_add_paragraph");if(buttonsAddParagraph){buttonsAddParagraph.forEach(button=>{button.addEventListener("click",addNewParagraph)})}}
function reorderParagraphs(){updateParagraphs();paragraphs.forEach((paragraph,indexCurrentParagraph)=>{indexCurrentParagraph++;let pTitleParagraph=paragraph.querySelector(".title_paragraph");pTitleParagraph.innerText=`Parágrafo ${indexCurrentParagraph}°`;let labelInfo=paragraph.querySelector(".small_label");labelInfo.for=`paragraph${indexCurrentParagraph}`;let inputTitle=paragraph.querySelector(".input_title_paragraph");inputTitle.setAttribute("name",`titleParagraph-${indexCurrentParagraph}`);let textareaParagraph=paragraph.querySelector(".text_content_paragraph");textareaParagraph.setAttribute("name",`contentParagraph-${indexCurrentParagraph}`)})}
function updateParagraphs(){paragraphs=document.querySelectorAll(".container_paragraphs .box_paragraph")};const btnOpenEye=document.querySelectorAll('.open_eye');const btnClosedEye=document.querySelectorAll('.closed_eye');btnOpenEye.forEach(btn=>{btn.onclick=function(){let boxActionsPass=this.parentElement;let input=boxActionsPass.closest('.box_password_auth').getElementsByTagName('input')[0];let btnCloseEye=boxActionsPass.querySelector('.closed_eye');this.style.display='none';btnCloseEye.style.display='block';input.type='text'}});btnClosedEye.forEach(btn=>{btn.onclick=function(){let boxActionsPass=this.parentElement;let input=boxActionsPass.closest('.box_password_auth').getElementsByTagName('input')[0];let btnOpenEye=boxActionsPass.querySelector('.open_eye');this.style.display='none';btnOpenEye.style.display='block';input.type='password'}})