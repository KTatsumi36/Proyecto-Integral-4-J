<?php

/**
 * Calcula el área de captación de agua de lluvia.
 * Fórmula general: Área = Volumen deseado / (Precipitación efectiva * Eficiencia)
 *
 * Parámetros:
 *  - $volumen: volumen de agua requerido (en litros o m³)
 *  - $precipitacion: precipitación media del lugar (en mm o m)
 *  - $eficiencia: eficiencia del sistema (valor entre 0 y 1, opcional, default 0.85)
 *
 * Si los datos están en litros y mm, el cálculo interno los convierte a m³ y m.
 */

function calcular_area_captacion($volumen, $precipitacion, $eficiencia = 0.85, $tipo = 'litros_mm') {
    if ($tipo === 'litros_mm') {
        $volumen = $volumen / 1000; // litros a m³
        $precipitacion = $precipitacion / 1000; // mm a m
    }
    if ($precipitacion * $eficiencia == 0) {
        return 0;
    }
    $area = $volumen / ($precipitacion * $eficiencia);
    return $area;
}

// Control de errores y persistencia de valores
$error = "";
$area = null;
$volumen = $precipitacion = $eficiencia = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $volumen = isset($_POST["volumen"]) ? trim($_POST["volumen"]) : "";
    $precipitacion = isset($_POST["precipitacion"]) ? trim($_POST["precipitacion"]) : "";
    $eficiencia = isset($_POST["eficiencia"]) && $_POST["eficiencia"] !== "" ? trim($_POST["eficiencia"]) : "0.85";

    if (!is_numeric($volumen) || $volumen <= 0) {
        $error = "Por favor, introduce un volumen válido mayor a 0.";
    } elseif (!is_numeric($precipitacion) || $precipitacion <= 0) {
        $error = "Por favor, introduce una precipitación válida mayor a 0.";
    } elseif (!is_numeric($eficiencia) || $eficiencia <= 0 || $eficiencia > 1) {
        $error = "La eficiencia debe ser un número entre 0.01 y 1.";
    } else {
        $area = calcular_area_captacion(floatval($volumen), floatval($precipitacion), floatval($eficiencia));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cálculo de Área de Captación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(120deg, #0074D9 0%, #2ECC40 100%);
            min-height: 100vh;
            color: #03396c;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background: #fff;
            padding: 2.2em 2em 2em 2em;
            border-radius: 22px;
            max-width: 430px;
            margin: 2em auto;
            box-shadow: 0 8px 32px rgba(0,70,120,0.18);
            position: relative;
            z-index: 2;
            animation: fadeIn 1.1s;
        }
        h2 {
            color: #2ECC40;
            text-align: center;
            margin-bottom: 1.2em;
            letter-spacing: 1px;
        }
        label {
            display: block;
            margin: 1em 0 0.4em 0;
            font-weight: 600;
        }
        input[type="number"] {
            width: 100%;
            padding: 0.7em 0.7em;
            border: 1.5px solid #b3c6e0;
            border-radius: 6px;
            font-size: 1em;
            margin-bottom: 0.2em;
            background: #f7fafc;
            transition: border 0.2s;
        }
        input[type="number"]:focus {
            border: 1.5px solid #2ECC40;
            outline: none;
            background: #e7fce4;
        }
        .input-group {
            margin-bottom: 1em;
        }
        button {
            margin-top: 1.7em;
            background: linear-gradient(90deg,#0074D9 60%,#2ECC40 100%);
            color: #fff;
            border: none;
            padding: 0.9em 2.7em;
            font-size: 1.15em;
            font-weight: 700;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.22s, transform 0.18s;
            box-shadow: 0 4px 16px rgba(0,116,217,0.10);
            letter-spacing: 1px;
        }
        button:hover {
            background: linear-gradient(90deg, #2ECC40 60%, #0074D9 100%);
            transform: scale(1.04);
        }
        .resultado {
            margin-top: 2em;
            background: #ecfcf1;
            color: #065c1d;
            padding: 1.35em;
            border-radius: 10px;
            border: 1px solid #bdf6cb;
            font-size: 1.18em;
            text-align: center;
        }
        .error {
            margin-top: 1em;
            background: #ffeaea;
            color: #a20000;
            padding: 1em;
            border-radius: 8px;
            border: 1.2px solid #ffb3b3;
            font-size: 1em;
            text-align: center;
        }
        .info {
            margin-top: 1em;
            font-size: 1em;
            color: #0074D9;
            background: #f3f8ff;
            border-left: 4px solid #2ECC40;
            padding: 0.8em 1em;
            border-radius: 7px;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 1em 0.4em 1.5em 0.4em;
                max-width: 98vw;
            }
            h2 { font-size: 1.2em; }
            button { font-size: 1em; }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to   { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>🌧️ Cálculo de Área de Captación de Agua de Lluvia</h2>
        <form method="post" autocomplete="off">
            <div class="input-group">
                <label for="volumen">Volumen deseado (litros):</label>
                <input type="number" name="volumen" id="volumen" min="1" step="any" required value="<?= htmlspecialchars($volumen) ?>">
            </div>
            <div class="input-group">
                <label for="precipitacion">Precipitación media anual (mm):</label>
                <input type="number" name="precipitacion" id="precipitacion" min="1" step="any" required value="<?= htmlspecialchars($precipitacion) ?>">
            </div>
            <div class="input-group">
                <label for="eficiencia">Eficiencia del sistema (0.01 - 1):</label>
                <input type="number" name="eficiencia" id="eficiencia" min="0.01" max="1" step="0.01" placeholder="0.85" value="<?= htmlspecialchars($eficiencia) ?>">
                <div class="info">Opcional: Usualmente entre 0.75 y 0.90. Por defecto es 0.85</div>
            </div>
            <button type="submit">Calcular Área</button>
        </form>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($area !== null && !$error): ?>
            <div class="resultado">
                <strong>Área de captación necesaria:</strong><br>
                <?= number_format($area, 2) ?> m²
            </div>
        <?php endif; ?>
        <div class="info" style="margin-top:2em;">
            <strong>¿Cómo se calcula?</strong><br>
            Área = Volumen (litros) ÷ (Precipitación anual (mm) × Eficiencia) <br>
            Todos los datos se convierten a sus unidades estándar antes del cálculo.
        </div>
    </div>
</body>
</html>
