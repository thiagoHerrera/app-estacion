document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('loading');
    const estacionesList = document.getElementById('estaciones-list');
    const template = document.getElementById('estacion-template');

    try {
        const response = await fetch('https://mattprofe.com.ar/proyectos/app-estacion/api/estaciones');
        const estaciones = await response.json();
        
        loading.style.display = 'none';
        
        estaciones.forEach(estacion => {
            const clone = template.content.cloneNode(true);
            
            clone.querySelector('.estacion-card').dataset.chipid = estacion.chipid;
            clone.querySelector('.apodo').textContent = estacion.apodo;
            clone.querySelector('.ubicacion').textContent = estacion.ubicacion;
            clone.querySelector('.count').textContent = estacion.visitas || 0;
            
            clone.querySelector('.estacion-card').addEventListener('click', () => {
                window.location.href = `detalle/${estacion.chipid}`;
            });
            
            estacionesList.appendChild(clone);
        });
        
    } catch (error) {
        loading.textContent = 'Error al cargar las estaciones';
        console.error('Error:', error);
    }
});