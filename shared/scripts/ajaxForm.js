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
                    // headers: {
                    //     'Content-Type': 'multipart/form-data'
                    // },
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
                    if(response.fixedMessage) {
                        let boxResponse = document.querySelector('.fixedMessage');
                        boxResponse.innerHTML = response.fixedMessage;
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