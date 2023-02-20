// import Chart from 'chart.js/auto';

(function() {
    if(document.querySelector('#regalos-grafica')){
        let regalos = [];
        const data = [
            { year: 2010, count: 10 },
            { year: 2011, count: 20 },
            { year: 2012, count: 15 },
            { year: 2013, count: 25 },
            { year: 2014, count: 22 },
            { year: 2015, count: 30 },
            { year: 2016, count: 28 },
        ];
        obtenerRegalso();
        async function obtenerRegalso(){
            const url = '/api/regalos';
            const respuesta = await fetch(url, {});
            const resultado = await respuesta.json();
            regalos = resultado;
            console.log(regalos);
            new Chart(
                document.getElementById('regalos-grafica'),
                {
                    type: 'bar',
                    data: {
                        labels: regalos.map(regalo => regalo.nombre),
                        datasets: [
                            {
                                label: '',
                                data: regalos.map(regalo => regalo.total),
                                backgroundColor: [
                                    '#ea580c',
                                    '#84cc16',
                                    '#22d3ee',
                                    '#a855f7',
                                    '#ef4444',
                                    '#14b8a6',
                                    '#db2777',
                                    '#e11d48',
                                    '#7e22ce'
                                ]
                            }
                        ]
                    },
                    options: {
                        plugins: {
                            legend: false
                        }
                    }
                }
            );
        }
    }
})();