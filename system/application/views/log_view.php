            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Log
                        <small>Berisi catatan aktivitas user</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Log</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini Anda bisa melihat semua aktifitas login / logout semua user.
                    </div>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <!-- tools -->
                                    <div class="pull-right box-tools">
                                      <button class="btn btn-sm btn-info" id="btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                                      <button class="btn btn-danger btn-sm" id="btn-hapus-log" name="btn-hapus-log"><i class="fa fa-times"></i> Hapus Semua Log</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        <?php
                                        if(!empty($datalog)) {
                                          foreach ($datalog as $key) {
                                        ?>
                                        <tr>
                                            <td><span class="label label-info"><?php echo $key->LOG_TIME;?></span> <?php echo $key->LOG_TEXT;?> { <i>user: <?php echo $key->USERNAME;?></i> }.</td>
                                        </tr>
                                        <?php } } else {  ?>
                                        <tr>
                                            <td>Tidak ada Log.</td>
                                        </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->

                    </div><!-- /.row (main row) -->


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- Modal Hapus Log -->
        <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 26%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-warning"></i> Hapus Log</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('log/hapuslog', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <p>Apakah Anda yakin ingin menghapus semua Log Aktivitas ?</p>
                                  </div>
                              </div>
                          </div>
                          <input type="hidden" name="hapus-id" value="<?php echo $this->access->get_roleid();?>" />
                          <?php echo form_close(); ?>
                      </div><!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-hapus" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Iya, Hapus</button>
                  </div>
              </div>
          </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#btn-hapus-log').click(function(){
                    $('#form-pesan-hapus').html('');
                    $('#modal-hapus').modal('show');
                });

                $('#btn-refresh').click(function(){
                    location.reload();
                });

                // Hapus log
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/log/hapuslog",
                        type:"POST",
                        data:$('#form-hapus').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-hapus').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 2000);
                                setTimeout(function(){$('#modal-hapus').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); }, 2500);
                            }else{
                                $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 5000);
                            }

                            $('#btn-hapus').removeClass('disabled');
                        }
                    });
                    return false;
                });
            });
        </script>

    </body>
</html>
