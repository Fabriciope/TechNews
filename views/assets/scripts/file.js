const inputFile = document.querySelectorAll(".input_file");

inputFile.forEach((input) => {
  input.addEventListener("change", (event) => {
    let input = event.target;
    let spanFileName = input.parentElement.querySelector(".file_name");
    spanFileName.innerText = input.files[0].name;
  });
});
