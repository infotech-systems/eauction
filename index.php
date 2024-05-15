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
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header  with-border">
        <h3 class="box-title">Live Offersheet List</h3>
      </div>
      <div class="box-body table-responsive no-padding">
        <table class="table table-striped">
          <tr>
            <th>Sl.</th>
            <th>Offersheet No</th>
            <th>Location</th>
            <th>Payment Type</th>
            <th>Contact Type</th>
            <th>Auction Start Time</th>
            <th>Auction End Time</th>
            <th>#</i></th>
          </tr>
          <?php
          $sl=0;
          $current_time=date("H:i:s",time());
          $sqle= "select auc_id,offer_srl,offer_nm,location,payment_type,contract_type,auc_start_time,auc_end_time,knockdown_start,knockdown_end ";
          $sqle.="from auction_mas ";
          $sqle.="where auc_start_time<=current_timestamp and auc_end_time>=current_timestamp ";
          $sth = $conn->prepare($sqle);
          $sth->execute();
          $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
          $row = $sth->fetchAll();
          foreach ($row as $key => $value) 
          {
              $sl++;
              $e_auc_id=$value['auc_id'];
              $e_offer_srl=$value['offer_srl'];
              $e_offer_nm=$value['offer_nm'];
              $e_location=$value['location'];
              $e_payment_type=$value['payment_type'];
              $e_contract_type=$value['contract_type'];
              $e_auc_start_time=$value['auc_start_time'];
              $e_auc_end_time=$value['auc_end_time'];
              $e_knockdown_start=$value['knockdown_start'];
              $e_knockdown_end=$value['knockdown_end'];

              $date_now = time(); //current timestamp
              if($date_now<strtotime($e_auc_start_time))
              {
                $tag='Auction not started';
              } 
              else 
              {
                if($date_now<strtotime($e_auc_end_time))
                {
                  $tag='Auction Running';
                } 
                else 
                {
                  $tag='Knockdown Process Running';
                }
              }
              ?>
              <tr>
                  <td><?php echo $sl; ?></td>
                  <td><?php echo $e_offer_srl; ?></td>
                  <td><?php echo $e_location; ?></td>
                  <td><?php echo $e_payment_type; ?></td>
                  <td><?php echo $e_contract_type; ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_start_time,0,10)).' '.substr($e_auc_start_time,11,5); ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_end_time,0,10)).' '.substr($e_auc_end_time,11,5); ?></td>
                  <td><a href="acive-offersheet-bid.php?param=<?php echo md5($e_auc_id); ?>"><i class="fa fa-hand-o-right"></i></a></td>
              </tr>
            <?php
          }
          ?>
        </table>
      </div>
                
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header  with-border">
        <h3 class="box-title">Upcoming Offersheet List</h3>
      </div>
      <div class="box-body table-responsive no-padding">
        <table class="table table-striped">
          <tr>
            <th>Sl.</th>
            <th>Offersheet No</th>
            <th>Location</th>
            <th>Payment Type</th>
            <th>Contact Type</th>
            <th>Auction Start Time</th>
            <th>Auction End Time</th>
            <th>View</i></th>
          </tr>
          <?php
          $sl=0;
          $current_time=date("H:i:s",time());
          $sqle= "select auc_id,offer_srl,offer_nm,location,payment_type,contract_type,auc_start_time,auc_end_time,knockdown_start,knockdown_end ";
          $sqle.="from auction_mas ";
          $sqle.="where  auc_start_time>current_timestamp ";
          $sth = $conn->prepare($sqle);
          $sth->execute();
          $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
          $row = $sth->fetchAll();
          foreach ($row as $key => $value) 
          {
              $sl++;
              $e_auc_id=$value['auc_id'];
              $e_offer_srl=$value['offer_srl'];
              $e_offer_nm=$value['offer_nm'];
              $e_location=$value['location'];
              $e_payment_type=$value['payment_type'];
              $e_contract_type=$value['contract_type'];
              $e_auc_start_time=$value['auc_start_time'];
              $e_auc_end_time=$value['auc_end_time'];
              $e_knockdown_start=$value['knockdown_start'];
              $e_knockdown_end=$value['knockdown_end'];

              $date_now = time(); //current timestamp
              if($date_now<strtotime($e_auc_start_time))
              {
                $tag='Auction not started';
              } 
              else 
              {
                if($date_now<strtotime($e_auc_end_time))
                {
                  $tag='Auction Running';
                } 
                else 
                {
                  $tag='Knockdown Process Running';
                }
              }
              ?>
              <tr>
                  <td><?php echo $sl; ?></td>
                  <td><?php echo $e_offer_srl; ?></td>
                  <td><?php echo $e_location; ?></td>
                  <td><?php echo $e_payment_type; ?></td>
                  <td><?php echo $e_contract_type; ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_start_time,0,10)).' '.substr($e_auc_start_time,11,5); ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_end_time,0,10)).' '.substr($e_auc_end_time,11,5); ?></td>
                  <td><a href="offersheet-view.php?param=<?php echo md5($e_auc_id); ?>"><i class="fa fa-hand-o-right"></i></a></td>
              </tr>
            <?php
          }
          ?>
        </table>
      </div>
                
    </div>
  </div>
</div>      
  
<div class="row">
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header  with-border">
        <h3 class="box-title">7 Days Archive Offersheet</h3>
      </div>
      <div class="box-body table-responsive no-padding">
        <table class="table table-striped">
          <tr>
            <th>Sl.</th>
            <th>Offersheet No</th>
            <th>Location</th>
            <th>Payment Type</th>
            <th>Contact Type</th>
            <th>Auction Start Time</th>
            <th>Auction End Time</th>
            <th>View</i></th>
          </tr>
          <?php
          $sl=0;
          $current_time=date("Y-m-d H:i:s");

          $sqle= " SELECT DATE_SUB(:current_time, INTERVAL 7 DAY) as prev_time ";
          $sth = $conn->prepare($sqle);
          $sth->bindParam(':current_time', $current_time);
          $sth->execute();
          $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
          $row = $sth->fetch();
          $prev_time=$row['prev_time'];
          $sqle= "select auc_id,offer_srl,offer_nm,location,payment_type,contract_type,auc_start_time,auc_end_time,knockdown_start,knockdown_end ";
          $sqle.="from auction_mas ";
          $sqle.="where  knockdown_end>=:prev_time and auc_end_time<current_timestamp  ";
          $sqle.=" ORDER BY auc_id DESC ";
          $sth = $conn->prepare($sqle);
          $sth->bindParam(':prev_time', $prev_time);
          $sth->execute();
          $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
          $row = $sth->fetchAll();
          foreach ($row as $key => $value) 
          {
              $sl++;
              $e_auc_id=$value['auc_id'];
              $e_offer_srl=$value['offer_srl'];
              $e_offer_nm=$value['offer_nm'];
              $e_location=$value['location'];
              $e_payment_type=$value['payment_type'];
              $e_contract_type=$value['contract_type'];
              $e_auc_start_time=$value['auc_start_time'];
              $e_auc_end_time=$value['auc_end_time'];
              $e_knockdown_start=$value['knockdown_start'];
              $e_knockdown_end=$value['knockdown_end'];

              $date_now = time(); //current timestamp
              if($current_time<strtotime($e_auc_start_time))
              {
                $tag='Auction not started';
              } 
              else 
              {
                if($current_time<strtotime($e_auc_end_time))
                {
                  $tag='Auction Running';
                } 
                else 
                {
                  $tag='Knockdown Process Running';
                }
              }
              ?>
              <tr>
                  <td><?php echo $sl; ?></td>
                  <td><?php echo $e_offer_srl; ?></td>
                  <td><?php echo $e_location; ?></td>
                  <td><?php echo $e_payment_type; ?></td>
                  <td><?php echo $e_contract_type; ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_start_time,0,10)).' '.substr($e_auc_start_time,11,5); ?></td>
                  <td><?php echo ansi_to_british(substr($e_auc_end_time,0,10)).' '.substr($e_auc_end_time,11,5); ?></td>
                  <td><a href="offersheet-view.php?param=<?php echo md5($e_auc_id); ?>"><i class="fa fa-hand-o-right"></i></a></td>
              </tr>
            <?php
          }
          ?>
        </table>
      </div>
                
    </div>
  </div>
</div>         
      
     
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