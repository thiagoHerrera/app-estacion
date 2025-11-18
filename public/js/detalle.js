document.addEventListener('DOMContentLoaded', async () => {
    const loading = document.getElementById('loading');
    const detalleDiv = document.getElementById('estacion-detalle');

    try {
        const response = await fetch('https://mattprofe.com.ar/proyectos/app-estacion/api/estaciones');
        const estaciones = await response.json();
        
        const estacion = estaciones.find(e => e.chipid === chipid);
        
        if (estacion) {
            document.getElementById('apodo').textContent = estacion.apodo;
            document.getElementById('ubicacion').textContent = estacion.ubicacion;
            
            loading.style.display = 'none';
            detalleDiv.style.display = 'block';
        } else {
            loading.textContent = 'Estación no encontrada';
        }
        
    } catch (error) {
        loading.textContent = 'Error al cargar los datos';
        console.error('Error:', error);
    }
});