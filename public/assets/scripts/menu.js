const btnMenu = document.querySelector(".btn_menu");
const btnCloseMenu = document.querySelector(".btn_menu_mobile_active");
// const containerMenuMobile = document.querySelector(".container_menu_active");

function toggleMenu() {
  document.body.classList.toggle("menu_active");
}
btnMenu.onclick = toggleMenu;
btnCloseMenu.onclick = toggleMenu;
// containerMenuMobile.onclick = toggleMenu;

function toggleActionsProfile() {
  this.classList.toggle("active_dropdown");
}

const liDropDown = document.querySelector(".li_profile");
if (liDropDown) {
  liDropDown.onclick = toggleActionsProfile;
}
