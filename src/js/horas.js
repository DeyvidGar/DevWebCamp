(function(){
    const horas = document.querySelector('#horas');
    if(horas){
        const dias = document.querySelectorAll('[name="dia_id"]');
        const categoria = document.querySelector('[name="categoria_id"]');
        const inputHiddenDias = document.querySelector('#dia_id');
        const inputHiddenHoras = document.querySelector('[name="hora_id"]');

        categoria.addEventListener('change', llenarBusqueda);
        dias.forEach(dia => dia.addEventListener('change', llenarBusqueda));

        //crear objeto en memoria para almacenar los objetos que queremos hacer interactivos
        let busqueda = {
            //el nombre debe ser el mismo que esta en el name del formulario
            categoria_id: +categoria.value || '', // (+) convierte a numero / (||) es un placeholder
            dia_id: document.querySelector('[name="dia_id"]:checked') ? +document.querySelector('[name="dia_id"]:checked').value : ''
        }

        // en caso de que el objeto contenga valores debemos de mostrar los horarios diponibles
        if(!Object.values(busqueda).includes('')){
            // POR QUE ASYNC: la funcion buscarEventos esta ejecutando las lineas donde pone la clase de desabilitado mientras nosotros la queremos quitar en la hora que pertenece a nuestro evento
            //con await esperamos a que termite de ejecutar la funcion de buscarEvento y funciones que se unen a esa para despues ejecutar las siguientes lineas
            (async () => {
                await buscarEventos();

                //seleccionar la hora del registro
                const id = inputHiddenHoras.value;
                if(!id) return;
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
                horaSeleccionada.classList.remove('horas__hora--desabilitado');
                horaSeleccionada.classList.add('horas__hora--seleccionado');
                horaSeleccionada.onclick = seleccionarHora;
            })();
        }

            function llenarBusqueda(e){
                busqueda[e.target.name] = parseInt(e.target.value);

            // para que se actualizen los campos con cada cambio en el campo check y select debemos: reiniciar campos ocultos y borrar el campo seleccionado
            // Reiniciar los campos ocultos
            inputHiddenDias.value = '';
            inputHiddenHoras.value = '';
             //borrar si existe una seleccionada, ya que solo puede seleccionar una
             const seleccionada = document.querySelector('.horas__hora--seleccionado');
             if(seleccionada) seleccionada.classList.remove('horas__hora--seleccionado');

            // con Object.values obtenemos un arreglo con solo los valores del objeto, includes obtiene si alguno esta vacio
            if(Object.values(busqueda).includes('')) return;
            buscarEventos();
        }

        async function buscarEventos() {
            const { dia_id, categoria_id } = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia_id}&categoria_id=${categoria_id}`;

            const resultadoConexion = await fetch(url);
            const eventos = await resultadoConexion.json();//eventos disponibles dependiendo los valores del objeto de busqueda

            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {
            //reiniciar las horas, desabilitamos todas las horas para posteriormente quitarle a las disponibles
            const listadoHoras = document.querySelectorAll('#horas LI');
            listadoHoras.forEach( hora => {
                hora.classList.add('horas__hora--desabilitado');
                hora.removeEventListener('click', seleccionarHora);
                }
            );

            // obtener solo las horas que ya estan registradas en la base de datos pendiendo del dia y categoria del evento
            const idHorasDisponibles = eventos.map(evento => evento.hora_id);
            // FILTER sirve para obtener ciertos valores en un arreglo, dado que este no es un arreglo debemos hacer lo siguiente
            const listadoHorasArray = Array.from(listadoHoras);

            // obtener y habilitar solo las horas que no estan ocupadas para esta categoria y dia del evento
            const habilitarHorasId = listadoHorasArray.filter( hora => !idHorasDisponibles.includes(hora.dataset.horaId));
            habilitarHorasId.forEach( habilitarLI => habilitarLI.classList.remove('horas__hora--desabilitado') );

            const horasDisponibles = document.querySelectorAll('#horas LI:not(.horas__hora--desabilitado)'); //el evento no aplica para los LI desabilitados
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora) );

        }

        function seleccionarHora(e){
            //borrar si existe una seleccionada, ya que solo puede seleccionar una
            const seleccionada = document.querySelector('.horas__hora--seleccionado');
            if(seleccionada) seleccionada.classList.remove('horas__hora--seleccionado');

            // mostrar seleccionado
            const li = e.target;
            li.classList.add('horas__hora--seleccionado');
            // console.log(e.target.dataset.horaId); id del registro
            inputHiddenHoras.value = li.dataset.horaId;
            inputHiddenDias.value = document.querySelector('[name="dia_id"]:checked').value;
        }
    }
})();