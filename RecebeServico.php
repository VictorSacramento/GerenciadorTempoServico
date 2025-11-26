//TODO: Só falta conectar o $tempo e o $nome com o gráfico que está no "head"

<?php
    if(isset($_POST['txtnome']) && isset($_POST['txtprofissao'])){
        if(isset($_POST['txtsalario']) && is_numeric($_POST['txtsalario'])){
            if(null != ($_POST['datainicio']) && null != ($_POST('datafinal'))){
                $nome = limpeza($_POST['txtnome']);
                $profissao = limpeza($_POST['txtprofissao']);
                $salario = limpeza($_POST['txtsalario']);
                $datai = limpeza($_POST['datainicio']);
                $datai = new DateTime($datai);
                $dataf = limpeza($_POST['datafinal']);
                $dataf = new DateTime($dataf);
                $tempo = $datai->diff($dataf);

                $sql = "INSERT INTO tb_funcionarios VALUES(nome, profissao, salario, data_inicio, data_fim, tempo) VALUES(?,?,?,?,?,?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssdsss", $nome, $profissao, $salario, $datai, $dataf, $tempo);
                mysqli_stmt_execute($stmt);
                echo mysqli_stmt_affected_rows($stmt) . "Registros afetados";
            }
        }
        else{
            echo "O campo salário deve ser preenchido e numérico";
        }
    }
    else{
        echo "Os campos de nome e profissão devem ser preenchido";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Copper", 8.94, "#b87333"],
        ["Silver", 10.49, "silver"],
        ["Gold", 19.30, "gold"],
        ["Platinum", 21.45, "color: #e5e4e2"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
      chart.draw(view, options);
  }
  </script>
<div id="barchart_values" style="width: 900px; height: 300px;"></div>
</head>
<body>
    <form action="" method="post">
        <p>
            <label for="txtdesc">Nome do funcionario: </label>
            <input type="text" id="txtnome" name="txtnome">
        </p>
        <p>
            <label for="txtdesc">Profissao: </label>
            <input type="text" id="txtprofissao" name="txtprofissao">
        </p>
        <p>
            <label for="txtdesc">Salario: </label>
            <input type="text" id="txtsalario" name="txtsalario">
        </p>
        <p>
            <label for="txtdesc">Data de inicio: </label>
            <input type="date" id="datainicio" name="datainicio">
        </p>
        <p>
            <label for="txtdesc">Data final: </label>
            <input type="date" id="datafinal" name="datafinal">
        </p>
        <p>
            <button type="submit" name="btnSubmit">Cadastrar</button>
        </p>
    </form>
    <div id="chart_id"></div>
</body>
</html>