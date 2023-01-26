(function(){
    const horas = document.querySelector('#horas');
    if(horas){
        //crear objeto en memoria para almacenar los objetos que queremos hacer interactivos
        let busqueda = {
            //el nombre debe ser el mismo que esta en el name del formulario
            categoria_id: '',
            dia_id: ''
        }

        const dias = document.querySelectorAll('[name="dia_id"]');
        const categoria = document.querySelector('[name="categoria_id"]');
        // const inputHiddenDias = document.querySelector('[name="dia_id"]');
        const inputHiddenHoras = document.querySelector('[name="hora_id"]');
        categoria.addEventListener('change', llenarBusqueda);
        dias.forEach(dia => dia.addEventListener('change', llenarBusqueda));

        function llenarBusqueda(e){
            busqueda[e.target.name] = e.target.value;

            // con Object.values obtenemos un arreglo con solo los valores del objeto, includes obtiene si alguno esta vacio
            if(Object.values(busqueda).includes('')) return;
            buscarEventos();
        }

        async function buscarEventos() {
            const { dia_id, categoria_id } = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia_id}&categoria_id=${categoria_id}`;

            const resultadoConexion = await fetch(url);
            const eventos = await resultadoConexion.json();
            // console.log(eventos);//eventos disponibles dependiendo los valores del objeto de busqueda

            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {
            // obtener solo las horas que ya estan registradas en la base de datos pendiendo del dia y categoria del evento
            const idHorasDisponibles = eventos.map(evento => evento.id);
            const listadoHoras = document.querySelectorAll('#horas LI');
            // FILTER sirve para obtener ciertos valores en un arreglo, dado que este no es un arreglo debemos hacer lo siguiente
            const listadoHorasArray = Array.from(listadoHoras);

            // obtener y habilitar solo las horas que no estan ocupadas para esta categoria y dia del evento
            const HabilitarHorasId = listadoHorasArray.filter( hora => !idHorasDisponibles.includes(hora.dataset.horaId));
            HabilitarHorasId.forEach( habilitarLI => habilitarLI.classList.remove('horas__hora--desabilitado') );

            const horasDisponibles = document.querySelectorAll('#horas LI:not(.horas__hora--desabilitado)'); //el evento no aplica para los LI desabilitados
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
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
        }
    }
})();