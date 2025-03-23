 
 
 document.querySelector('form').addEventListener('submit', function(event) {
            const password1 = document.getElementById('contraseña1').value;
            const password2 = document.getElementById('contraseña2').value;
            const errorMessage = document.getElementById('errorMessage');
            const password2Input = document.getElementById('contraseña2');

            if (password1 !== password2) {
                errorMessage.style.display = 'block'; 
                password2Input.classList.add('error');
                event.preventDefault();
            }else{
                errorMessage.style.display = 'none';
                password2Input.classList.remove('error');
            }
        });

        

        