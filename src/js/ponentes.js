(function(){
    const ponentesInput = document.querySelector('#ponente');
    if(ponentesInput){
        let ponentes = [];
        let ponentesFiltrando = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');

        // esta funcion muestra el ponente seleccionado cuando se recarga la pagina o cuando se edita un eventos
        if(ponenteHidden.value){
            ( async () => {
                // ya que esta funcion es async necesitamos usar un IFEE con async y await para mostrar el json
                const ponente = await obtenerPonente(ponenteHidden.value);

                //insertar HTML
                const ponenteHTML = document.createElement('LI');
                ponenteHTML.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado');
                ponenteHTML.textContent = `${ponente.nombre} ${ponente.apellido}`;
                listadoPonentes.appendChild(ponenteHTML);
            })();
        }
        obtenerPonentes();
        ponentesInput.addEventListener('input', leerInput);

        async function obtenerPonentes(){
            const url = `/api/ponentes`;
            const resultadoConexion = await fetch(url);
            const ponentes = await resultadoConexion.json();

            formatearPonentes(ponentes);
        }

        async function obtenerPonente(id){
            const url = `/api/ponente?id=${id}`;
            const resultadoConexion = await fetch(url);
            const ponente = await resultadoConexion.json();
            return ponente;
        }

        function formatearPonentes(arrayPonentes = []){
            ponentes = arrayPonentes.map( ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
        }

        function leerInput(e) {
            const input = e.target.value;
            if(input.length > 3) {
                // esta exprecion regula busca un patron y con la flag "i" le decimos que busque sin importar mayusculas o minusculas
                // la exprecion con le metodo .search() retorna 0 si encuentra la similitud en caso contrario el valor da -1
                const exprecion = new RegExp(input, "i");
                ponentesFiltrando = ponentes.filter( ponente => {
                    //filtramos por cada ponenete, si el nombre del ponente con la funcion de exprecion regular da un valor diferente a -1 es decir 0 signidica que encontro las coincidencias por lo tanto lo almacena en el arreglo
                    if(ponente.nombre.toLowerCase().search(exprecion) != -1)
                        return ponente
                });

                mostrarPonentes();
            } else {
                ponentesFiltrando = [];
                limpiarPonentes();
            }
        }

        function mostrarPonentes(){
            limpiarPonentes();
            if(ponentesFiltrando.length > 0){
                ponentesFiltrando.forEach( ponente => {
                    const ponenteLI = document.createElement('LI');
                    ponenteLI.classList.add('listado-ponentes__ponente');
                    ponenteLI.textContent = ponente.nombre;
                    ponenteLI.dataset.ponenteId = ponente.id;
                    ponenteLI.onclick = seleccionarPonente;
                    listadoPonentes.appendChild(ponenteLI);
                });
            } else {
                const noPonentes = document.createElement('P');
                noPonentes.classList.add('listado-ponentes__no-ponentes');
                noPonentes.textContent = 'No se encontro ponente.';
                listadoPonentes.appendChild(noPonentes);
            }
        }

        function limpiarPonentes(){
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }
        }

        function seleccionarPonente(e){
            const ponente = e.target;
            //remover clase si existe
            const ponenteSeleccionado = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponenteSeleccionado) ponenteSeleccionado.classList.remove('listado-ponentes__ponente--seleccionado');

            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
})();