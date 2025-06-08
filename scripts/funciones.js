function registro()
{
    document.querySelector("#formulario-registro").showModal();
}

function cancelar1()
{
    document.querySelector("#formulario-registro").close();
}

function cancelar2()
{
    document.querySelector("#dialog-eliminar-cuenta").close();
}    

function cancelar3()
{
    document.querySelector("#formulario-usuario").close();
}

function cerrarSesion()
{
    window.location.href = "sesion/logout.php";    
}

const div = document.querySelector('.perfil');
const button = document.querySelector('.perfil .button');
        
div.addEventListener('mouseover', () => {
    button.disabled = false;
});

div.addEventListener('mouseout', () => {
    button.disabled = true;
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();

let sobreAbierto = false;

function mostrarPremio() 
{
    if (sobreAbierto)
    {
        return;
    }

    sobreAbierto = true;

    fetch('actualizar_sobres.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetch('generar_premio.php')
                    .then(response => response.text())
                    .then(html => {
                        const div = document.querySelector(".premio");
                        div.innerHTML = html;
                        div.style.display = "block";
                    });
            } else {
                alert(data.mensaje);
                sobreAbierto = false;
            }
        })
        .catch(error => {
            console.error('Error al abrir sobre:', error);
            sobreAbierto = false;
        });
}

function cerrarSobre()
{
    window.location.href = "./index.php";
    sobreAbierto = false;   
}

function eliminarUsuario()
{
    document.querySelector("#dialog-eliminar-cuenta").showModal();
}

function borrar()
{
    window.location.href = "sesion/eliminar_usuario.php";
}

function editarUsuario(button) 
{
    var id = button.getAttribute('data-id');
    var nombre = button.getAttribute('data-nombre');
    var email = button.getAttribute('data-email');
    var esAdmin = button.getAttribute('data-esadmin') === 'true';

    var dialog = document.getElementById('formulario-usuario');
    var form = dialog.querySelector('form');

    form.id_usuario.value = id;
    form.nombre_usuario.value = nombre;
    form.email.value = email;
    form.admin.checked = esAdmin;

    dialog.showModal();
}