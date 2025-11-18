let charts = {};
let estacionData = null;

document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('loading');
    const detalleDiv = document.getElementById('estacion-detalle');

    try {
        const response = await fetch('https://mattprofe.com.ar/proyectos/app-estacion/api/estaciones');
        const estaciones = await response.json();
        
        estacionData = estaciones.find(e => e.chipid === chipid);
        
        if (estacionData) {
            document.getElementById('apodo').textContent = estacionData.apodo;
            document.getElementById('ubicacion').textContent = estacionData.ubicacion;
            
            loading.style.display = 'none';
            detalleDiv.style.display = 'block';
            
            initCharts();
            loadStationData();
            
            // Actualizar cada minuto
            setInterval(loadStationData, 60000);
        } else {
            loading.textContent = 'Estación no encontrada';
        }
        
    } catch (error) {
        loading.textContent = 'Error al cargar los datos';
        console.error('Error:', error);
    }
});

function initCharts() {
    // Configuración común para todos los gráficos
    const commonConfig = {
        type: 'line',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Temperatura
    charts.temp = new Chart(document.getElementById('tempChart'), {
        ...commonConfig,
        data: {
            labels: [],
            datasets: [{
                label: 'Temperatura (°C)',
                data: [],
                borderColor: '#ff6b6b',
                backgroundColor: 'rgba(255, 107, 107, 0.1)',
                tension: 0.4
            }]
        }
    });

    // Humedad
    charts.hum = new Chart(document.getElementById('humChart'), {
        ...commonConfig,
        data: {
            labels: [],
            datasets: [{
                label: 'Humedad (%)',
                data: [],
                borderColor: '#4ecdc4',
                backgroundColor: 'rgba(78, 205, 196, 0.1)',
                tension: 0.4
            }]
        }
    });

    // Viento
    charts.wind = new Chart(document.getElementById('windChart'), {
        ...commonConfig,
        data: {
            labels: [],
            datasets: [{
                label: 'Viento (km/h)',
                data: [],
                borderColor: '#45b7d1',
                backgroundColor: 'rgba(69, 183, 209, 0.1)',
                tension: 0.4
            }]
        }
    });

    // Presión
    charts.press = new Chart(document.getElementById('pressChart'), {
        ...commonConfig,
        data: {
            labels: [],
            datasets: [{
                label: 'Presión (hPa)',
                data: [],
                borderColor: '#f7b731',
                backgroundColor: 'rgba(247, 183, 49, 0.1)',
                tension: 0.4
            }]
        }
    });

    // Riesgo de incendio
    charts.fire = new Chart(document.getElementById('fireChart'), {
        ...commonConfig,
        data: {
            labels: [],
            datasets: [{
                label: 'Riesgo',
                data: [],
                borderColor: '#ff9ff3',
                backgroundColor: 'rgba(255, 159, 243, 0.1)',
                tension: 0.4
            }]
        }
    });
}

async function loadStationData() {
    try {
        const response = await fetch(`https://mattprofe.com.ar/proyectos/app-estacion/api/datos/${chipid}`);
        const data = await response.json();
        
        if (data && data.length > 0) {
            const latest = data[data.length - 1];
            
            // Actualizar valores actuales
            document.getElementById('tempValue').textContent = `${latest.temperatura}°C`;
            document.getElementById('humValue').textContent = `${latest.humedad}%`;
            document.getElementById('windValue').textContent = `${latest.viento} km/h`;
            document.getElementById('pressValue').textContent = `${latest.presion} hPa`;
            document.getElementById('fireValue').textContent = getRiesgoIncendio(latest.temperatura, latest.humedad);
            
            // Actualizar timestamp
            document.getElementById('last-update').textContent = new Date().toLocaleTimeString();
            
            // Preparar datos para gráficos (últimos 10 registros)
            const recentData = data.slice(-10);
            const labels = recentData.map(d => new Date(d.fecha).toLocaleTimeString());
            
            // Actualizar gráficos
            updateChart(charts.temp, labels, recentData.map(d => d.temperatura));
            updateChart(charts.hum, labels, recentData.map(d => d.humedad));
            updateChart(charts.wind, labels, recentData.map(d => d.viento));
            updateChart(charts.press, labels, recentData.map(d => d.presion));
            updateChart(charts.fire, labels, recentData.map(d => getRiesgoIncendioNumerico(d.temperatura, d.humedad)));
        }
        
    } catch (error) {
        console.error('Error al cargar datos:', error);
    }
}

function updateChart(chart, labels, data) {
    chart.data.labels = labels;
    chart.data.datasets[0].data = data;
    chart.update();
}

function getRiesgoIncendio(temp, hum) {
    const riesgo = (temp * 2) - hum;
    if (riesgo < 20) return 'Bajo';
    if (riesgo < 40) return 'Medio';
    if (riesgo < 60) return 'Alto';
    return 'Extremo';
}

function getRiesgoIncendioNumerico(temp, hum) {
    return (temp * 2) - hum;
}