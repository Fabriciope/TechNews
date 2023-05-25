Object.values(document.forms).forEach( form => {
    if(form.classList.contains('formAjax')) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            //iniciar load
            document.querySelector(".ajax_load").style.display = "flex";

            const formData = new FormData(form);

            try {
                fetch(form.action, {
                    method: form.method,
                    body: formData
                }).then( data => {
                    return data.json();
                }).then( response => {

                    if(response.redirect) {
                        location.href = response.redirect;
                    }
                    if(response.message) {
                        let boxResponse = document.querySelector('.ajax_response');
                        boxResponse.innerHTML = response.message;
                    }
    
                    //terminar load
                    document.querySelector(".ajax_load").style.display = "none";
                })
            } catch(error) {
                //location.href = 'url' + '/oops/problemas/'; 
                console.log(error);
            }
        });
    }
});