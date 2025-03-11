<?php
$host = "localhost";
$user = "root";
$password = "senha";
$database = "bd";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : date("Y-m-d", strtotime("-7 days"));

$sql = "SELECT 
    temperatura, 
    umidade, 
    umidade_solo, 
    DATE_FORMAT(created_at, '%H:%i') AS data_formatada
FROM leituras 
WHERE DATE(created_at) >= '$data_inicial'
ORDER BY created_at";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "created_at" => $row["data_formatada"], 
        "temperatura" => (float)$row["temperatura"],
        "umidade" => (float)$row["umidade"],
        "umidade_solo" => (int)$row["umidade_solo"]
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Sensores</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <h2>Relatório de Sensores</h2>

    <form id="filtro-form">
        <label for="data_inicial">Data Inicial:</label>
        <input type="date" id="data_inicial" name="data_inicial" value="<?= $data_inicial ?>">
        <button type="submit">Filtrar</button>
    </form>

    <div id="grafico-temperatura" style="width:80%; height:400px;"></div>
    <div id="grafico-umidade" style="width:80%; height:400px;"></div>
    <div id="grafico-umidade-solo" style="width:80%; height:400px;"></div>

    <script>
        function carregarGraficos(data) {
            let categorias = data.map(d => d.created_at);
            let temperaturas = data.map(d => d.temperatura);
            let umidades = data.map(d => d.umidade);
            let umidades_solo = data.map(d => d.umidade_solo);

            Highcharts.chart('grafico-temperatura', {
                chart: { type: 'line' },
                title: { text: 'Temperatura (°C)' },
                xAxis: { categories: categorias },
                yAxis: { title: { text: 'Temperatura (°C)' } },
                series: [{ name: 'Temperatura', data: temperaturas }]
            });

            Highcharts.chart('grafico-umidade', {
                chart: { type: 'line' },
                title: { text: 'Umidade do Ar (%)' },
                xAxis: { categories: categorias },
                yAxis: { title: { text: 'Umidade (%)' } },
                series: [{ name: 'Umidade', data: umidades }]
            });

            Highcharts.chart('grafico-umidade-solo', {
                chart: { type: 'line' },
                title: { text: 'Umidade do Solo' },
                xAxis: { categories: categorias },
                yAxis: { title: { text: 'Umidade' } },
                series: [{ name: 'Umidade do Solo', data: umidades_solo }]
            });
        }

        $(document).ready(function() {
            let dados = <?= json_encode($data); ?>;
            carregarGraficos(dados);

            $('#filtro-form').submit(function(e) {
                e.preventDefault();
                let data_inicial = $('#data_inicial').val();

                $.get('index.php', { data_inicial }, function(response) {
                    let novaPagina = $(response);
                    let novosDados = JSON.parse(novaPagina.find('script').text().match(/(\[.*\])/)[1]);
                    carregarGraficos(novosDados);
                });
            });
        });
    </script>
</body>
</html>
