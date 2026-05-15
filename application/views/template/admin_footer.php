<footer class="main-footer">
    <p style="text-align: center;">Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url('admin'); ?>"><?php echo SITE_NAME; ?></a>. All rights reserved.</p>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">      
	<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
	<!-- Home tab content -->
	<div class="tab-pane" id="control-sidebar-home-tab">        

	</div>
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!-- <script src="<?php echo base_url('assets/plugins/morris/morris.min.js'); ?>"></script> -->
<!-- Sparkline -->
<script src="<?php echo base_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/plugins/knob/jquery.knob.js'); ?>"></script>
<!-- daterangepicker -->

<!-- <script src="<?php //echo base_url('assets/plugins/daterangepicker/daterangepicker.js'); ?>"></script> -->
<!-- datepicker -->
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/plugins/fastclick/fastclick.js'); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/app.min.js'); ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?php echo base_url('assets/dist/js/pages/dashboard.js'); ?>"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js'); ?>"></script>
<!-- Datetime Picker -->
<script src="<?php echo base_url('assets/plugins/datetimepicker/datetimepicker.js'); ?>"></script>
<!-- MultiSelect JS -->
<script src="<?php echo base_url('assets/plugins/multiselect/jquery.multiselect.js'); ?>"></script>  
<!-- DataTables -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<!-- Full calender -->
<!-- <script src="<?php //echo base_url('assets/plugins/fullcalendar/moment-with-locales.min.js'); ?>"></script> -->



<script src="<?php echo base_url('assets/dist/js/admincommon.js'); ?>"></script>


<script type="text/javascript">
  
    $(function () {
        //$("#example1").DataTable();
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        var request;
        $("#webapiform").submit(function (event) {

            // Prevent default posting of form - put here to work in case of errors
            event.preventDefault();

            // Abort any pending request
            if (request) {
                request.abort();
            }
            // setup some local variables
            var $form = $(this);

            // Let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");
            var apiName = $('#apiname').val();
            var controllername = $('#controllername').val();
            //alert(apiName);
            // Serialize the data in the form
            var serializedData = $form.serialize();

            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.

            // $inputs.prop("disabled", true);

            // Fire off the request to /form.php
            request = $.ajax({
                url: BASE_URL + "/" + controllername + "/" + apiName,
                type: "post",
                data: serializedData
            });

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR) {
                // Log a message to the console
                console.log("Hooray, it worked!");
                $('#webapiresponse').text(JSON.stringify(response)).css('color', 'red');
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown) {
                // Log the error to the console
                console.error(
                        "The following error occurred: " +
                        textStatus, errorThrown
                        );
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // Reenable the inputs
                //$inputs.prop("disabled", false);

            });

        });
	

        // $('#datetimepicker1').datetimepicker();
        // $('#datetimepicker2').datetimepicker();

        $('#datetimepicker1').datetimepicker({
            inline: false,
            sideBySide: true
        });
        $('#datetimepicker2').datetimepicker({
            useCurrent: false,
            inline: false,
            sideBySide: true
        });

        $("#datetimepicker1").on("dp.change", function (e) {
            $('#datetimepicker2').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker2").on("dp.change", function (e) {
            $('#datetimepicker1').data("DateTimePicker").maxDate(e.date);
        });
	

    });
</script>

<!--ckeditor -->
<script src="<?php echo base_url('assets/plugins/ckeditor/ckeditor.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/ckeditor/samples/js/sample.js');?>"></script>
<script type="text/javascript">
  initSample();
</script>
<script>
CKEDITOR.replace('editor', {
  height: 250,
  extraPlugins: 'section,colorbutton,colordialog,forms,font,div,span,stylescombo',
  
});
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'editor11' );
      CKEDITOR.add            
</script>

<script type="text/javascript">
      CKEDITOR.replace( 'editor12' );
      CKEDITOR.add            
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'editor13' );
      CKEDITOR.add            
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'editor14' );
      CKEDITOR.add            
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'editor15' );
      CKEDITOR.add            
</script>
<script type="text/javascript">
      CKEDITOR.replace( 'editor16' );
      CKEDITOR.add            
</script>
</body>
</html>
