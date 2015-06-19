            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <b>Hai!</b> <?php echo $welcome_message;?>
                    </div>
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <?php
                            // for admin
                            if($this->access->get_roleid() == 40) {
                        ?>
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 id="boxukm">
                                    0
                                    </h3>
                                    <p>
                                        Jumlah UKM
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-sitemap"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/ukm');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="boxuser">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah User
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/user');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 id="boxlog">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Log
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-warning"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/log');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3 id="boxlaporan">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Laporan
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/laporan');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <?php } // akhir admin ?>


                        <?php
                            // for manajemen
                            if($this->access->get_roleid() == 41) {
                        ?>
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3 id="boxukm">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah UKM
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-sitemap"></i>
                                </div>
                                <a href="<?php echo base_url();?>" target="_blank" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    <h3 id="boxnotif">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Notifikasi
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-warning"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/notifikasi');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="boxrem">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Reminder
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-check"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/reminder');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3 id="boxlaporan">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Laporan
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/laporan');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <?php } // akhir manajemen ?>

                        <?php
                            // for ukm
                            if($this->access->get_roleid() == 42) {
                        ?>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-teal">
                                <div class="inner">
                                    <h3 id="boxanggota">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Anggota
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/anggota');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    <h3 id="boxnotif">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Notifikasi
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-warning"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/notifikasi');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="boxagenda">
                                        0
                                    </h3>
                                    <p>
                                        Jumlah Agenda
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-sort-alpha-asc"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/agenda');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3 id="boxlaporan">
                                        0
                                    </h3>
                                    <p>
                                        Laporan Terkirim
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a href="<?php echo site_url('dashboard/laporan');?>" class="small-box-footer">
                                    Info Lengkap <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <?php } // akhir ukm ?>

                    </div><!-- /.row -->

                    <?php
                      // for ukm
                      if($this->access->get_roleid() == 42) {
                    ?>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-6">
                            <div class="box box-info">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title">Notifikasi Terbaru</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        
                                        <?php
                                        if(!empty($datanotif)) {
                                          foreach($datanotif as $key) :
                                        ?>
                                        <tr>
                                            <td><span class="label label-<?php echo $key->TIPE_NAMA;?>"&bsp;&bsp;&bsp;><?php echo $key->TEKS;?></span> <?php echo substr($key->NOTIF_ACTIVITY,0);?>.</td>
                                        </tr>
                                        <?php endforeach; } else {  ?>
                                        <tr>
                                            <td>Tidak ada notifikasi.</td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        <section class="col-lg-6">

                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="fa fa-sort-alpha-asc"></i>
                                    <h3 class="box-title">Agenda Terbaru</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        <?php
                                        //$dataagenda = $this->load->agenda_model();
                                        if(!empty($dataagenda)) {
                                          foreach ($dataagenda as $key) :
                                        ?>
                                        <tr>
                                            <td><span class="label label-<?php echo $key->TIPE_NAMA;?>"><?php echo $key->TEKS . " ------>  " . $key->AGENDA_TIME;?></span> <?php echo substr($key->AGENDA_TITLE,0);?>.</td>
                                        </tr>
                                        <?php endforeach; } else {  ?>
                                        <tr>
                                            <td>Tidak ada agenda.</td>
                                        </tr>
                                      <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>

                        </section><!-- right col -->
                    </div><!-- /.row (main row) -->

                    <?php } ?>

                    <!-- info akses -->
                    <div class="alert alert-warning" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        Rendered in <i>{elapsed_time} sec</i>, with {memory_usage}. From <?php echo $this->input->ip_address();?>
                    </div>


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <script type="text/javascript">
            function refresh_jumlah(){
                $.getJSON('<?php echo site_url('/dashboard/get_databox');?>', function(obj) {
                    $('#boxukm').html(obj.boxukm);
                    $('#boxuser').html(obj.boxuser);
                    $('#boxlog').html(obj.boxlog);
                    $('#boxlaporan').html(obj.boxlaporan);
                    $('#boxnotif').html(obj.boxnotif);
                    $('#boxanggota').html(obj.boxanggota);
                    $('#boxagenda').html(obj.boxagenda);
                    $('#boxrem').html(obj.boxrem);
                });
            }

            $(document).ready(function() {
                refresh_jumlah();
                var auto_refresh = setInterval(
                    function(){
                        refresh_jumlah();
                    }, 10000
                )
            });
        </script>

    </body>
</html>
