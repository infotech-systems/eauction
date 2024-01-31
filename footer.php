  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <div class="pull-left hidden-xs">
      <strong> 
      &copy; Designed and Developed by <a href="https://infotechsystems.in">Infotech Systems</a>.
      
      
    <!--  <?php echo date('Y'); ?> <a href="#"> <b><?php echo $ses_orgn_nm; ?></a>. </b></strong> All rights reserved. -->
    </div>
   <div class="pull-right hidden-xs">
<p>  <?php echo $ses_orgn_nm; ?>.</p>
    </div> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</footer>
</div>

<script src="<?php echo $full_url; ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $full_url; ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo $full_url; ?>/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?php echo $full_url; ?>/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $full_url; ?>/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script src="<?php echo $full_url; ?>/dist/js/adminlte.min.js"></script>
<script src="<?php echo $full_url; ?>/dist/js/demo.js"></script>
<!--<script src="<?php echo $full_url; ?>/plugins/daterangepicker/daterangepicker.js"></script>-->
<script src="<?php echo $full_url; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>


  $(function () {
   $('.select2').select2()
	 $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    $('[data-mask]').inputmask()
	$('#reservation').daterangepicker({format: 'DD/MM/YYYY'  ,'opens': 'left'});
	$('.datetimemask').inputmask({
        mask: "1/2/y h:s:s",
        placeholder: "mm/dd/yyyy hh:mm:ss",
        alias: "datetime",
        hourFormat: "24"
    });

	$('#example1').DataTable({
	 'autoWidth'   : false,	
	 'pageLength': 50
	})
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
	  'pageLength': 50
    })
    $('#example3').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : true,
	  'pageLength': 50
    })
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
  $(window).load(function(){
        $('#preloder_page').fadeOut(); // set duration in brackets
    });

</script>

</body>
</html>
<?php
$conn=null;
?>