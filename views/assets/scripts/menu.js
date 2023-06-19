const btnMenu = document.querySelector(".btn_menu");
const btnCloseMenu = document.querySelector(".btn_menu_mobile_active");
// const containerMenuMobile = document.querySelector(".container_menu_active");

function toggleMenu() {
  document.body.classList.toggle("menu_active");
}
btnMenu.onclick = toggleMenu;
btnCloseMenu.onclick = toggleMenu;
// containerMenuMobile.onclick = toggleMenu;

const liDropDown = document.querySelector(".li_profile");

function toggleActionsProfile() {
  this.classList.toggle("active_dropdown");
}

if (liDropDown) {
  liDropDown.onclick = toggleActionsProfile;
}
