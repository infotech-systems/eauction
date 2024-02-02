<?php
header("X-XSS-Protection: 1;mode = block");
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
include('./header.php'); 
//include('./search.php');
//echo "UID: $ses_user_id--$ses_user_type ==$ses_uid<br>";
//--------------- Patirnt Count --------------------- //

?>

        
      
     
<?php
include('./footer.php');
?>
<script src="./plugins/chartjs/Chart.min.js"></script>

<script>
  /*
  $(function () {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
   var barChartData = {
     labels: [<?php // echo substr($month_desc,0,-1); ?>],
     
      datasets: [
        {
          label: "Open",
          fillColor: "#00a65a",
          strokeColor: "#00a65a",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php // echo substr($regn,0,-1); ?>]
        },
        {
          label: "Close",
          fillColor: "#b70300",
          strokeColor: "#b70300",
          pointColor: "#b70300",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php //echo substr($release,0,-1); ?>]
        }
        ,
        {
          label: "Reject",
          fillColor: "#f39c12",
          strokeColor: "#f39c12",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
        
       data: [<?php //echo substr($death,0,-1); ?>]
        }
      ]
    };

    barChartData.datasets[1].fillColor = "#b70300";
    barChartData.datasets[1].strokeColor = "#b70300";
    barChartData.datasets[1].pointColor = "#b70300";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = true;
    barChart.Bar(barChartData, barChartOptions);
  });
  $(document).ready(function () {                            
    $("#radio_1, #radio_2", "#radio_3").change(function () {
        if ($("#radio_1").is(":checked")) {
            $('#div1').show();
        }
        else if ($("#radio_2").is(":checked")) {
            $('#div2').show();
        }
        else 
            $('#div3').show();
    });        
});*/
</script>