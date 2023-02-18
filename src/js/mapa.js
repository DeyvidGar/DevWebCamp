if(document.querySelector('#mapa')){
    const lat = 18.80419;
    const lng = -97.18105;
    const zoom = 17;

    var map = L.map('mapa').setView([lat, lng], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h3 class="mapa__titulo">DevWebCamp</h3>
            <p class="mapa__descripcion">Visitanos aquí :)</p>
        `)
        .openPopup();
}