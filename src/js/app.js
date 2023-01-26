(function(){
    const alerta = document.querySelector('.alerta');
    if(alerta){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
})();