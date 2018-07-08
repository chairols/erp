<div class="box box-primary">
    <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i> <h3 class="box-title">Gráfico</h3>
    </div>
    <div class="box-body">
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
    </div>
</div>


    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', '<?=$moneda['moneda']?>'],
          <?php foreach($historial as $h) { ?>
          ['<?=$h['fecha']?>', <?=$h['valor']?>],  
          <?php } ?>
        ]);

        var options = {
          title: 'Cotización',
          hAxis: {title: 'Fecha',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
