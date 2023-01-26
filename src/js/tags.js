(function(){
    const tagInput = document.querySelector('#tags_input');
    if(tagInput){
        const divTags = document.querySelector('#tags');
        const inputHiddenTags = document.querySelector('[name="tags"]');
        //para no resetear los valores cuando envia datos
        const valoresTemporales = inputHiddenTags.value === '' ? [] : inputHiddenTags.value.split(',');
        let tags = valoresTemporales;
        mostrarTags();

        tagInput.addEventListener('keypress', guardarTag)
        function guardarTag(e){
            //keycode lee el valor ingresado en el teclado 13 es la tecla enter y 44 la coma
            if(e.keyCode === 13 || e.keyCode === 44){
                //prevenimos que el usuario envie el formualrio o que ingrese un valor
                e.preventDefault();
                //si el input esta vacio nos salimos de la funcion
                if(e.target.value.trim() === '' || e.target.value < 1) return;

                //el arrelo tiene una copia del arreglo actual y almacena el valor del input
                tags = [...tags, e.target.value.trim()];

                tagInput.value = '';
                mostrarTags();
                actulaizarInputHidden();
            }
        }

        function mostrarTags(){
            divTags.textContent = '';
            tags.forEach(tag => {
                const listado = document.createElement('LI');
                listado.classList.add('formulario__tag');
                listado.textContent = 'x';
                listado.onclick = eliminarTag;
                const nombre = document.createElement('SPAN');
                nombre.textContent = tag;
                listado.appendChild(nombre);
                divTags.appendChild(listado);
            })
        }

        function actulaizarInputHidden(){
            //convertimos el arrglo en un string
            inputHiddenTags.value = tags.toString();
        }

        function eliminarTag(e){
            //eliminamos el elemento que targete el evento e en escaso es LI
            e.target.remove();
            //con filter, obtenemos los valores del arreglo que sean diferentes de el que targetemos
            tags = tags.filter(tag => tag !== e.target.lastChild.textContent);
            actulaizarInputHidden();
            mostrarTags();
        }
    }
})()