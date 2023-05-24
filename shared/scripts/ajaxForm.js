// Array(document.forms).forEach( form => {
//     if(form.classList.contains("formAjax")) {
//         console.log(form);
//     }
// })

Object.values(document.forms).forEach( form => {
    if(form.classList.contains('formAjax')) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            //iniciar load

            const formData = new FormData(form);

            try {
                fetch(form.action, {
                    method: form.method,
                    headers: {
                        'Content-Type' : 'application/json'
                    },
                    body: formData
                }).then( data => {
                    data.json();
                }).then( response => {
                    if(response.redirect) {
                        location.href = response.redirect;
                    }
                    if(response.message) {
                        let boxResponse = document.querySelector('.ajax_response');
                        boxResponse.innerHTML = response.message;
                    }
    
                    //terminar load
                })
            } catch(error) {
                //location.href = 'url' + '/oops/problemas/'; 
                console.log(error);
            }
        });
    }
});