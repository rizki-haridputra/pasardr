<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0 | Page rendered in <strong>{elapsed_time}</strong> seconds.
    </div>
    <strong>Copyright &copy; 2025 - <?= date('Y') ?> <a href="https://google.com" target="blank">Elnur Firdaus</a>.</strong> All rights reserved.
</footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Sweet Alert -->
<script src="<?= base_url('assets') ?>/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/izitoast/iziToast.min.js"></script>
<!-- jQuery 3 -->
<script src="<?= base_url('assets') ?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets') ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url('assets') ?>/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url('assets') ?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets') ?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets') ?>/dist/js/demo.js"></script>
<!-- PACE -->
<script src="<?= base_url('assets') ?>/bower_components/pace/pace.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url('assets') ?>/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Data Table -->
<script src="<?= base_url('assets') ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets') ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('assets') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- CK Editor -->
<script src="<?= base_url('assets') ?>/bower_components/ckeditor/ckeditor.js"></script>
<?php foreach ($this->db->get('tb_aplikasi')->result() as $dAplFoot) { } ?>
<script>
    $(document).ready(function() {
      setInterval(function() {
        var start_time = new Date("<?php echo $this->session->userdata('start_time'); ?>");
        var now = new Date(new Date().toLocaleString('en-US', { timeZone: <?= '"' . $dAplFoot->timezone . '"' ?> }));
        var time_diff = now - start_time;
        var seconds = Math.floor(time_diff / 1000);
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        minutes = minutes % 60;
        seconds = seconds % 60;
        var session_time = ("0" + hours).slice(-2) + ":" + ("0" + minutes).slice(-2) + ":" + ("0" + seconds).slice(-2);
        var timezone = new Date().toLocaleString('en-US', { timeZone: <?= '"' . $dAplFoot->timezone . '"' ?>}).split(' ')[2];
        $("#session_time").html(session_time);
      }, 1000);
    });
</script>
<script>
  $(document).ready(function() {
    setInterval(function() {
        var timeZone = <?= '"' . $dAplFoot->timezone . '"' ?>;
        var date = new Date();
        var options = { timeZone, hour12: false };
        
        var time = date.toLocaleTimeString("en-US", options);
        
        // Gunakan opsi timeZone untuk menampilkan tanggal sesuai dengan zona waktu yang ditentukan.
        var day = date.toLocaleDateString("id-ID", { timeZone, weekday: "long" });
        var fullDate = date.toLocaleDateString("id-ID", { timeZone, day: "numeric", month: "long", year: "numeric" });

        $("#clock").html(day + ", " + fullDate + " " + time);
    }, 1000);
  });
</script>
<script>
  //Konfirmasi
  $('.tombol-yakin').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    const isiData = $(this).data('isidata');
    swal({
      title: 'Apakah anda yakin?',
      text: isiData,
      icon: 'warning',
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
          document.location.href = href;
        }
      });
  });

  // Data Table
  $(document).ready( function () {
    $('#dataTable').DataTable();
  } );

  // Data Table
  $(document).ready( function () {
    $('.dataTable').DataTable();
  } );
  
  // Notifikasi Success
  const flashData = $('.flash-data').data('flashdata');
  if (flashData){
    iziToast.success({
      title: 'Selamat!',
      message: flashData,
      position: 'topRight',
    });
  }

  // Notifikasi Error
  const flashDaraError = $('.flash-data-error').data('flashdataerror');
  if (flashDaraError){
    iziToast.error({
      title: 'Maaf!',
      message: flashDaraError,
      position: 'topRight',
    });
  }

  // Efek Loading
  $(document).ajaxStart(function () {
    Pace.restart()
  })

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })

  //Editor
  $(function () {
    // Replace all <textarea> elements with class "ckeditor" with CKEditor instances.
    $('.ckeditor').each(function() {
        CKEDITOR.replace($(this).attr('name'));
    });

    // Replace all <textarea> elements with class "textarea" with WYSIHTML5 instances.
    $('.textarea').wysihtml5();
  });


    // Sow Password
  $(document).ready(function() {
    $('#checkbox').click(function() {
      if($(this).is(':checked')){
        $('#password').attr('type','text');
      } else {
        $('#password').attr('type','password');
      }
    });
  });
</script>
<script>
    $(document).ready(function () {
        // Initially hide the status messages
        $('.statusPassword').hide();

        // Disable the update button by default
        $('#updateButton').prop('disabled', true);

        // Add an event listener to the 'Ulangi Password' input field
        $('#ulangiPassword').on('input', function () {
            // Get the values of 'New Password' and 'Ulangi Password'
            var newPassword = $('#newPassword').val();
            var ulangiPassword = $(this).val();

            // Check if the passwords match
            if (newPassword === ulangiPassword) {
                $('.statusPassword:contains("Password Sama")').show();
                $('.statusPassword:contains("Password Tidak Sama")').hide();
                // Enable the update button if passwords match
                $('#updateButton').prop('disabled', false);
            } else {
                $('.statusPassword:contains("Password Sama")').hide();
                $('.statusPassword:contains("Password Tidak Sama")').show();
                // Disable the update button if passwords do not match
                $('#updateButton').prop('disabled', true);
            }
        });
    });
</script>
</body>
</html>