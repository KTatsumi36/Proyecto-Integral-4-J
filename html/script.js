function calcularCotizacion() {
    // Obtener valores del formulario
    const tipoTubo = document.getElementById('tubo').value;
    const diametro = document.getElementById('diametro').value;
    const metrosTubo = parseFloat(document.getElementById('metrosTubo').value);
    const metrosCanaleta = parseFloat(document.getElementById('metrosCanaleta').value);
    const codos = parseInt(document.getElementById('codos').value);
    const rejillas = parseInt(document.getElementById('rejillas').value);
    const trampas = parseInt(document.getElementById('trampas').value);
    const bajantes = parseInt(document.getElementById('bajantes').value);
    const conexiones = parseInt(document.getElementById('conexiones').value);
    const tapas = parseInt(document.getElementById('tapas').value);
    const filtros = parseInt(document.getElementById('filtros').value);

    // Asignar precios según el tipo y diámetro del tubo
    let precioTubo = 0;
    if (tipoTubo === 'PVC') {
        if (diametro == 100) precioTubo = 80;
        else if (diametro == 150) precioTubo = 120;
        else if (diametro == 200) precioTubo = 180;
        else if (diametro == 300) precioTubo = 250;
        else if (diametro == 400) precioTubo = 350;
    } else if (tipoTubo === 'PEAD') {
        if (diametro == 100) precioTubo = 100;
        else if (diametro == 150) precioTubo = 140;
        else if (diametro == 200) precioTubo = 200;
        else if (diametro == 300) precioTubo = 300;
        else if (diametro == 400) precioTubo = 400;
    } else if (tipoTubo === 'Concreto') {
        if (diametro == 100) precioTubo = 150;
        else if (diametro == 150) precioTubo = 200;
        else if (diametro == 200) precioTubo = 300;
        else if (diametro == 300) precioTubo = 450;
        else if (diametro == 400) precioTubo = 600;
    }

    // Precios fijos de los demás materiales
    const precioCanaletaMetro = 90;
    const precioCodo = 50;
    const precioRejilla = 150;
    const precioTrampa = 800;
    const precioBajante = 350;
    const precioConexion = 100;
    const precioTapa = 250;
    const precioFiltro = 500;

    // Calcular el total
    const total =
        (precioTubo * metrosTubo) +
        (precioCanaletaMetro * metrosCanaleta) +
        (precioCodo * codos) +
        (precioRejilla * rejillas) +
        (precioTrampa * trampas) +
        (precioBajante * bajantes) +
        (precioConexion * conexiones) +
        (precioTapa * tapas) +
        (precioFiltro * filtros);

    // Mostrar el resultado en el div con id="resultado"
    const resultadoDiv = document.getElementById('resultado');
    resultadoDiv.style.display = 'block';
    resultadoDiv.innerHTML = `
        <strong>Resumen de Cotización:</strong><br>
        Tipo de Tubo: ${tipoTubo}<br>
        Diámetro: ${diametro} mm<br>
        Metros de Tubo: ${metrosTubo}<br>
        Metros de Canaleta: ${metrosCanaleta}<br>
        Codos: ${codos}<br>
        Rejillas: ${rejillas}<br>
        Trampas: ${trampas}<br>
        Bajantes: ${bajantes}<br>
        Conexiones en Y: ${conexiones}<br>
        Tapas o Registros: ${tapas}<br>
        Filtros Pluviales: ${filtros}<br><br>
        <strong>Total: $${total.toFixed(2)} MXN</strong>
    `;
}
