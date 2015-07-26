            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Notifikasi
                        <small>Daftar Notifikasi yang diterima</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Notifikasi</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini anda bisa melihat semua notifikasi yang ditujukan untuk anda.
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
                                        <button class="btn btn-success btn-sm" id="btn-baca-notif" name="btn-baca-notif"><i class="fa fa-check"></i> Baca Semua</button>
                                        <button class="btn btn-danger btn-sm" id="btn-hapus-notif" name="btn-hapus-notif"><i class="fa fa-times"></i> Hapus Semua Notif</button>
                                    </div>
                                    <!-- /.tools -->
                                <div class="box-body table-responsive no-padding">
                                </div><!-- /.box-header -->
                                    <table class="table">
                                        <tbody>
                                        <?php
                                        if(!empty($datanotif)) {
                                          foreach ($datanotif as $key) {
                                        ?>
                                        <tr style="background:<?php echo $key->NOTIF_READ == 0 ? "#f5f5f5" : "none"; ?>">
                                            <td><span class="label label-<?php echo $key->TIPE_NAMA;?>"><?php echo $key->TEKS ." / " . $key->NOTIF_TIME;?></span> <?php echo substr($key->NOTIF_ACTIVITY,0);?> { <i>dikirim oleh <?php echo $key->USERNAME;?></i> }.</td>
                                            <td><button class="btn btn-xs btn-flat <?php echo $key->NOTIF_READ == 0 ? "btn-primary" : "btn-default disabled"; ?>" onclick="modalbacasatu('<?php echo $key->NOTIF_ID?>', '<?php echo addslashes($key->NOTIF_TIME)?>', '<?php echo addslashes($key->USERNAME)?>')"><i class="fa fa-check"></i> Baca</button></td>
                                        </tr>
                                        <?php } } else {  ?>
                                        <tr>
                                            <td>Tidak ada notifikasi.</td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->

                    </div><!-- /.row (main row) -->


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- Modal Hapus notif -->
        <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 26%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-warning"></i> Hapus Notifikasi</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('notifikasi/hapusnotif', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <p>Apakah Anda yakin ingin menghapus semua Notifikasi ?</p>
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

        <!-- Modal baca semua notif -->
        <div class="modal fade" id="modal-baca" data-backdrop="static">
          <div class="modal-dialog" style="width: 26%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-warning"></i> Baca Notifikasi</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-baca">
                          </span>
                          <?php echo form_open('notifikasi/bacasemua', 'id="form-baca"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <p>Apakah Anda yakin ingin menandai semua notifikasi telah dibaca ?</p>
                                  </div>
                              </div>
                          </div>
                          <input type="hidden" name="baca-id" value="<?php echo $this->access->get_roleid();?>" />
                          <?php echo form_close(); ?>
                      </div><!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-baca" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Iya, Tandai Semua</button>
                  </div>
              </div>
          </div>
        </div>

        <!-- Modal baca notif -->
        <div class="modal fade" id="modal-bacasatu" data-backdrop="static">
          <div class="modal-dialog" style="width: 26%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-warning"></i> Baca Notifikasi</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-bacasatu">
                          </span>
                          <?php echo form_open('notifikasi/bacanotif', 'id="form-bacasatu"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <input type="hidden" id="notifid" name="notifid" />
                                      <p>Apakah Anda yakin ingin menandai notifikasi ini telah dibaca ?</p>
                                      <div class="callout callout-info">
                                          <p>Notif ID : <span id="notif-id"> </span></p>
                                          <p>Waktu : <span id="notif-waktu"> </span></p>
                                          <p>Dari : <span id="notif-dari"> </span></p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <input type="hidden" name="bacasatu-id" value="<?php echo $this->access->get_roleid();?>" />
                          <?php echo form_close(); ?>
                      </div><!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-bacasatu" type="button" class="btn btn-primary"><i class="fa fa-check"></i> Iya, Tandai</button>
                  </div>
              </div>
          </div>
        </div>

        <script type="text/javascript">
            function modalbacasatu(id, waktu, user){
                $('#form-pesan-bacasatu').html('');
                $('#modal-bacasatu').modal('show');
                $('#notifid').val(id);
                $('#bacasatu-id').val(id);
                $('#notif-id').html(id);
                $('#notif-waktu').html(waktu);
                $('#notif-dari').html(user);
            }

            $(document).ready(function() {
                $('#btn-hapus-notif').click(function(){
                    $('#form-pesan-hapus').html('');
                    $('#modal-hapus').modal('show');
                });

                $('#btn-baca-notif').click(function(){
                    $('#form-pesan-baca').html('');
                    $('#modal-baca').modal('show');
                });

                $('#btn-refresh').click(function(){
                    location.reload();
                });

                // Hapus notif
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/notifikasi/hapusnotif",
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

                // baca semua notif
                $('#btn-baca').click(function(){
                    $('#form-baca').submit();
                    $('#btn-baca').addClass('disabled');
                });
                $('#form-baca').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/notifikasi/bacasemua",
                        type:"POST",
                        data:$('#form-baca').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-baca').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-baca').html('')}, 2000);
                                setTimeout(function(){$('#modal-baca').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); }, 2500);
                            }else{
                                $('#form-pesan-baca').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-baca').html('')}, 5000);
                            }

                            $('#btn-baca').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // baca notif
                $('#btn-bacasatu').click(function(){
                    $('#form-bacasatu').submit();
                    $('#btn-bacasatu').addClass('disabled');
                });
                $('#form-bacasatu').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/notifikasi/bacanotif",
                        type:"POST",
                        data:$('#form-bacasatu').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-bacasatu').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-bacasatu').html('')}, 2000);
                                setTimeout(function(){$('#modal-bacasatu').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); }, 2500);
                            }else{
                                $('#form-pesan-bacasatu').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-bacasatu').html('')}, 5000);
                            }

                            $('#btn-bacasatu').removeClass('disabled');
                        }
                    });
                    return false;
                });

            });
        </script>

    </body>
</html>
