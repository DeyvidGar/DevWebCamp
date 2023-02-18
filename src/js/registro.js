import Swal from 'sweetalert2';

(function(){
    let eventos = []; // arreglo que se llenara segun los que seleccione el usuario
    const botonAgregar = document.querySelectorAll('.evento__agregar')
    const registroResumen = document.querySelector('#registro-resumen');
    const formualrio = document.querySelector('#registro');

    if(registroResumen){
        botonAgregar.forEach(boton => boton.addEventListener('click', agregarEvento));
        formualrio.addEventListener('submit', submitFormulario);
        mostrarEventos();//solo para ver parrafo de no eventos

        function agregarEvento(e){
            //seleccionamos el boton y nos dirigimos al padre del elemento y seleccionamos el contenedor que contiene el nombre del evento
            // console.log(e.target.parentElement.querySelector('.evento__nombre').textContent.trim())
            const nombreEvento = e.target.parentElement.querySelector('.evento__nombre').textContent.trim();

            // console.log(e.target.dataset.id) //id del evento
            const idEvento = e.target.dataset.id;

            // buscamos con find y dentro de los objetos buscamos por objeto
            const existe = eventos.find(evento => evento.id === idEvento);

            if(existe){
                eliminarEvento(idEvento);
                mostrarEventos();
                return;
            }
            // para limitar la cantidad de eventos
            if(eventos.length < 5){
                eventos = [ ...eventos, {
                    id: idEvento,
                    nombre: nombreEvento
                }];
                // marcar el evento
                e.target.parentElement.classList.add('evento__informacion--desabilitado');

                mostrarEventos();
            } else{
                Swal.fire({
                    title: 'Error!',
                    text: 'Máximo 5 eventos',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }

        }
        function mostrarEventos(){
            limpiarEventos();
            if(eventos.length > 0){
                // si existen valores en el arrglo iteramos en cada uno y le asignamos un contenedor
                eventos.forEach(evento => {
                    const eventosDom = document.createElement('DIV');
                    eventosDom.classList.add('registro__evento');

                    const h3 = document.createElement('H3');
                    h3.classList.add('registro__nombre');
                    h3.textContent = evento.nombre;

                    const boton = document.createElement('BUTTON');
                    boton.classList.add('registro__eliminar');
                    boton.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    boton.onclick = function(){
                        eliminarEvento(evento.id);
                    }

                    eventosDom.appendChild(h3);
                    eventosDom.appendChild(boton);
                    registroResumen.appendChild(eventosDom);
                })
            }else{
                const noEventos = document.createElement('P');
                noEventos.classList.add('registro__texto');
                noEventos.textContent = 'No hay eventos, selecciona hasta 5.';
                registroResumen.appendChild(noEventos);
            }
        }
        function eliminarEvento(id){
            const eventoDom = document.querySelector(`[data-id="${id}"]`);
            eventoDom.parentElement.classList.remove('evento__informacion--desabilitado');
            //devuelve todos los eventos que son diferentes de el nombre del evento
            eventos = eventos.filter(evento => evento.id !== id);
            mostrarEventos();
        }
        function limpiarEventos(){
            while(registroResumen.firstChild){
                registroResumen.removeChild(registroResumen.firstChild);
            }
        }
        async function submitFormulario(e){
            e.preventDefault();
            //PARA CREAR UN NUEVO ARREGLO EN BASE A NUESTRO ARREGLO DE OBJETOS USAMOS MAP QUE SE ENCARGA DE ITERAR UN ARREGLO QUE PUEDE TENER CIERTA FUNCION CON CADA OBJETO Y DE AHI CREAR UN ARRGLO
            const eventosId = eventos.map(evento => evento.id);
            const regaloId = document.querySelector('#regalo').value;
            //validar
            if(eventos.length === 0 || regaloId === ''){
                Swal.fire({
                    title: 'Error!',
                    text: 'Elige almenos un evento y un regalo.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                return;
            }
            // objetos de formdata
            const datos = new FormData();
            datos.append('evento_id', eventosId);
            datos.append('regalo_id', regaloId);

            const url = '/finalizar-registro/conferencias';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resulatado = await respuesta.json();
            if(resulatado.resultado){
                Swal.fire({
                    title: 'Registro exitoso!',
                    text: 'Tu registro fue creado correctamente, te esperamos en DevWebCamp :D',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'Hubo un error al crear tu registro recarga la pagina o intentalo de nuevo.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        }
    }
})();