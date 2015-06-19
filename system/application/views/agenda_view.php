            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Agenda
                        <small>Manajemen agenda pada SIM UKM</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Agenda</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini Anda bisa menambahkan, memodifikasi informasi, dan menghapus agenda
                    </div>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-8">
                            <div class="box box-info">
                                <div class="box-header">
                                    <!-- tools -->
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-sm btn-info" id="btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                                        <button class="btn btn-sm btn-success" id="btn-tambah-agenda"><i class="fa fa-plus"></i> Tambah Agenda</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table-agenda" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Judul</th>
                                                <th>Waktu</th>
                                                <th>Status</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->
                        <!-- Right Col -->
                        <section class="col-lg-4">
                            <div class="row">
                                <div class="col-xs-12">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3 id="boxsemua">
                                                0
                                            </h3>
                                            <p>Jumlah Agenda</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                            <h3 id="boxpublish">
                                                0
                                            </h3>
                                            <p>Jumlah Publish</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                    <!-- small box -->
                                    <div class="small-box bg-navy">
                                        <div class="inner">
                                            <h3 id="boxdraft">
                                                0
                                            </h3>
                                            <p>Jumlah Draft</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3 id="boxselesai">
                                                0
                                            </h3>
                                            <p>Jumlah Selesai</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section><!-- /.Right col -->

                    </div><!-- /.row (main row) -->


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

      <!-- Modal Hapus Agenda -->
      <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 350px;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sort-alpha-asc"></i> Hapus Agenda</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('agenda/hapus', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <input type="hidden" id="hapus-id" name="hapus-id" />
                                          <input type="hidden" id="hapus-uname" name="hapus-uname" />
                                          <p>Apakah Anda yakin ingin menghapus Agenda berikut ?</p>
                                          <div class="callout callout-info">
                                              <p>Judul : <span id="hapus-nama"> </span></p>
                                              <p>Waktu : <span id="hapus-waktu"> </span></p>
                                          </div>

                                  </div>
                              </div>
                          </div>
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

      <!-- Modal Edit Agenda -->
      <div class="modal fade" id="modal-edit" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sort-alpha-asc"></i> Edit Agenda</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-edit">
                          </span>
                          <?php echo form_open('agenda/edit', 'id="form-edit"') ?>
                          <input type="hidden" id="edit-id" name="edit-id" readonly="" />
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Judul:</span>
                                        <input type="text" class="form-control" id="edit-judul" name="edit-judul" placeholder="Judul Agenda" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Waktu:</span>
                                        <input type="text" class="form-control" id="edit-time" name="edit-time" placeholder="Waktu Awal" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                      <textarea name="edit-teks" id="edit-teks" class="form-control" placeholder="Deskripsi Agenda" style="height: 70px;overflow:auto;resize:none"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Status:</span>
                                        <select class="form-control" id="edit-status" name="edit-status">
                                            <option value="1">Publish</option>
                                            <option value="0">Draft</option>
                                            <option value="3">Selesai</option>
                                        </select>

                                      </div><!-- /.input group -->
                                    </div>
                                  </div>
                              </div>
                              <?php echo form_close(); ?>
                          </div><!-- /.box-body -->
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-edit" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
              </div>
          </div>
      </div> <!-- /.modal-edit -->

      <!-- Modal Tambah Agenda -->
      <div class="modal fade" id="modal-tambah" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sort-alpha-asc"></i> Tambah Agenda</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-tambah">
                          </span>
                          <?php echo form_open('agenda/tambah', 'id="form-tambah"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Judul:</span>
                                        <input type="text" class="form-control" id="tambah-judul" name="tambah-judul" placeholder="Judul Agenda" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Waktu:</span>
                                        <input type="text" class="form-control" id="tambah-time" name="tambah-time" placeholder="Waktu Agenda" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                      <textarea name="tambah-teks" id="tambah-teks" class="form-control" placeholder="Deskripsi Agenda" style="height: 70px;overflow:auto;resize:none"></textarea>
                                    </div>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Status:</span>
                                        <select class="form-control" id="tambah-status" name="tambah-status">
                                            <option value="1">Publish</option>
                                            <option value="0">Draft</option>
                                            <option value="3">Selesai</option>
                                        </select>

                                      </div><!-- /.input group -->
                                    </div>
                                  </div>
                              </div>
                              <?php echo form_close(); ?>
                          </div><!-- /.box-body -->
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-simpan" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
              </div>
          </div>
      </div> <!-- /.modal-tambah -->

      <!-- Modal lihat Agenda -->
      <div class="modal fade" id="modal-lihat" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sort-alpha-asc"></i> Lihat Detail Agenda</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body">
                          <dl class="dl-horizontal">
                              <dt>Judul</dt>
                              <dd><span id="lihat-judul"></span></dd>
                              <dt>Waktu</dt>
                              <dd><span id="lihat-waktu"></span></dd>
                              <dt>Deskripsi</dt>
                              <dd><span id="lihat-teks"></span></dd>
                              <dt>Status</dt>
                              <dd><span id="lihat-status"></span></dd>
                          </dl>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                  </div>
              </div>
          </div>
      </div> <!-- /.modal-lihat -->

        <script type="text/javascript">
            function modaledit(id, judul, status, teks, time, timeto){
                var waktu = time + " sampai " + timeto;
                $('#edit-id').val(id);
                $('#edit-judul').val(judul);
                $('#edit-teks').val(teks);
                $('#edit-time').val(waktu);
                $("#edit-status option").filter(function(){
                    return ( ($(this).val() == status) || ($(this).text() == status) );
                }).prop('selected', true);
                $('#modal-edit').modal('show');
            }

            function modallihat(judul, status, teks, time, timeto){
                var waktu = time + " sampai " + timeto;
                $('#lihat-judul').html(judul);
                $('#lihat-teks').html(teks);
                $('#lihat-waktu').html(waktu);
                $('#lihat-status').html(status);
                $('#modal-lihat').modal('show');
            }

            function modalhapus(id, judul, time){
                $('#form-pesan-hapus').html('');
                $('#modal-hapus').modal('show');
                $('#hapus-id').val(id);
                $('#hapus-uname').val(judul);
                $('#hapus-nama').html(judul);
                $('#hapus-waktu').html(time);
            }

            function refresh_jumlah(){
                $.getJSON('<?php echo site_url();?>/agenda/get_databox', function(obj) {
                    $('#boxsemua').html(obj.boxsemua);
                    $('#boxpublish').html(obj.boxpublish);
                    $('#boxdraft').html(obj.boxdraft);
                    $('#boxselesai').html(obj.boxselesai);
                });
            }

            $(document).ready(function() {
                $('#tambah-time').daterangepicker({timePicker: true, timePickerIncrement: 1, format: 'YYYY-MM-DD hh:mm:ss', separator: ' sampai '});
                $('#edit-time').daterangepicker({timePicker: true, timePickerIncrement: 1, format: 'YYYY-MM-DD hh:mm:ss', separator: ' sampai '});

                refresh_jumlah();
                $('#btn-refresh').click(function(){
                    $('#table-agenda').dataTable().fnReloadAjax();
                    refresh_jumlah();
                });

                $('#modal-hapus').on('shown.bs.modal', function (e) {
                    $('#btn-hapus').focus();
                });

                $('#modal-edit').on('shown.bs.modal', function (e) {
                    $('#edit-nama').focus();
                });

                $('#btn-tambah-agenda').click(function(){
                    $('#form-pesan-tambah').html('');
                    $('#modal-tambah').modal('show');
                });

                // Tambah agenda
                $('#btn-simpan').click(function(){
                    $('#form-tambah').submit();
                    $('#btn-simpan').addClass('disabled');
                });
                $('#form-tambah').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/agenda/tambah",
                        type:"POST",
                        data:$('#form-tambah').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-tambah').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 2000);
                                setTimeout(function(){$('#modal-tambah').modal('hide')}, 2500);
                                setTimeout(function(){ $('#table-agenda').dataTable().fnReloadAjax(); refresh_jumlah(); }, 2500);
                            }else{
                                $('#form-pesan-tambah').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 5000);
                            }

                            $('#btn-simpan').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Hapus agenda
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/agenda/hapus",
                        type:"POST",
                        data:$('#form-hapus').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-hapus').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 2000);
                                setTimeout(function(){$('#modal-hapus').modal('hide')}, 2500);
                                setTimeout(function(){ $('#table-agenda').dataTable().fnReloadAjax(); refresh_jumlah(); }, 2500);
                            }else{
                                $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 5000);
                            }

                            $('#btn-hapus').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Edit agenda
                $('#btn-edit').click(function(){
                    $('#form-edit').submit();
                    $('#btn-edit').addClass('disabled');
                });

                $('#form-edit').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/agenda/edit",
                        type:"POST",
                        data:$('#form-edit').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-edit').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-edit').html('')}, 2000);
                                setTimeout(function(){$('#modal-edit').modal('hide')}, 2500);
                                setTimeout(function(){ $('#table-agenda').dataTable().fnReloadAjax(); refresh_jumlah(); }, 2500);
                            }else{
                                $('#form-pesan-edit').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-edit').html('')}, 2000);
                            }

                            $('#btn-edit').removeClass('disabled');
                        }
                    });
                    return false;
                });
            });
        </script>

    </body>
</html>
