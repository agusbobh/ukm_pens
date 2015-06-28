            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Anggota
                        <small>Manajemen anggota pada SIM UKM</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Anggota</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini Anda bisa menambahkan, memodifikasi informasi, dan menghapus anggota
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
                                        <button class="btn btn-sm btn-success" id="btn-tambah-anggota"><i class="fa fa-plus"></i> Tambah Anggota</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table-anggota" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Status</th>
                                                <th>Jabatan</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          foreach($record_anggota as $row){
                                          ?>
                                            <tr>
                                              <td>
                                                <?php echo $row['ID']?>
                                              </td>
                                              <td>
                                                <?php echo $row['NAMA'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['STATUS'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['JABATAN'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['OPSI'] ?>
                                              </td>
                                            </tr>
                                          <?php }
                                          ?>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Status</th>
                                                <th>Jabatan</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->
                        <!-- Right Col -->
                        <section class="col-lg-4">
                            <div class="row">
                                <div class="col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3 id="boxanggota">
                                                0
                                            </h3>
                                            <p>Jumlah Anggota</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3 id="boxnon">
                                                0
                                            </h3>
                                            <p>Anggota Nonaktif</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3 id="boxaktif">
                                                0
                                            </h3>
                                            <p>Anggota Aktif</p>
                                        </div>
                                        <div class="small-box-footer">
                                        </div>
                                    </div>
                                    <!-- small box -->
                                    <div class="small-box bg-maroon">
                                        <div class="inner">
                                            <h3 id="boxpengurus">
                                                0
                                            </h3>
                                            <p>Jumlah Pengurus</p>
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

      <!-- Modal Hapus Anggota -->
      <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 350px;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-users"></i> Hapus Anggota</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('anggota/hapus', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <input type="hidden" id="hapus-id" name="hapus-id" />
                                          <input type="hidden" id="hapus-uname" name="hapus-uname" />
                                          <p>Apakah Anda yakin ingin menghapus Anggota berikut ?</p>
                                          <div class="callout callout-info">
                                              <p>Nama : <span id="hapus-nama"> </span></p>
                                              <p>Level : <span id="hapus-level"> </span></p>
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

      <!-- Modal Edit Anggota -->
      <div class="modal fade" id="modal-edit" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-users"></i> Edit Anggota</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-edit">
                          </span>
                          <?php echo form_open('anggota/edit', 'id="form-edit"') ?>
                          <input type="hidden" id="edit-id" name="edit-id" readonly="" />
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Nama:</span>
                                        <input type="text" class="form-control" id="edit-nama" name="edit-nama" placeholder="Nama Anggota" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <span class="input-group-addon">Status:</span>
                                        <select class="form-control" id="edit-status" name="edit-status">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>

                                        </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">

                                        <div class="input-group">
                                          <span class="input-group-addon">Jabatan:</span>
                                          <select class="form-control" id="edit-level" name="edit-level">
                                              <option value="10">Anggota</option>
                                              <option value="11">Pengurus</option>
                                              <option value="12">Ketua</option>
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

      <!-- Modal Tambah Anggota -->
      <div class="modal fade" id="modal-tambah" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-users"></i> Tambah Anggota</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-tambah">
                          </span>
                          <?php echo form_open('anggota/tambah', 'id="form-tambah"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Nama:</span>
                                        <input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Nama Anggota" />
                                      </div><!-- /.input group -->
                                    </div>
                                      <div class="form-group">

                                        <div class="input-group">
                                          <span class="input-group-addon">Level:</span>
                                          <select class="form-control" id="tambah-level" name="tambah-level">
                                              <option value="10">Anggota</option>
                                              <option value="11">Pengurus</option>
                                              <option value="12">Ketua</option>
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

        <script type="text/javascript">
            function modaledit(id, nama, status, level){
                $('#edit-id').val(id);
                $('#edit-nama').val(nama);
                $("#edit-status option").filter(function(){
                    return ( ($(this).val() == status) || ($(this).text() == status) );
                }).prop('selected', true);
                $("#edit-level option").filter(function(){
                  return ( ($(this).val() == level) || ($(this).text() == level) );
                }).prop('selected', true);
                $('#modal-edit').modal('show');
            }

            function modalhapus(id, nama, level){
                $('#form-pesan-hapus').html('');
                $('#modal-hapus').modal('show');
                $('#hapus-id').val(id);
                $('#hapus-uname').val(nama);
                $('#hapus-nama').html(nama);
                $('#hapus-level').html(level);
            }

            function refresh_jumlah(){
                $.getJSON('<?php echo site_url();?>/anggota/get_databox', function(obj) {
                    $('#boxanggota').html(obj.boxanggota[0].TOTAL);
                    $('#boxpengurus').html(obj.boxpengurus[0].TOTAL);
                    $('#boxaktif').html(obj.boxaktif[0].TOTAL);
                    $('#boxnon').html(obj.boxnon[0].TOTAL);
                });
            }

            $(document).ready(function() {
                refresh_jumlah();
                $('#btn-refresh').click(function(){
                    location.reload();
                    refresh_jumlah();
                });

                $('#modal-hapus').on('shown.bs.modal', function (e) {
                    $('#btn-hapus').focus();
                });

                $('#modal-edit').on('shown.bs.modal', function (e) {
                    $('#edit-nama').focus();
                });

                $('#btn-tambah-anggota').click(function(){
                    $('#form-pesan-tambah').html('');
                    $('#modal-tambah').modal('show');
                });

                // Tambah User
                $('#btn-simpan').click(function(){
                    $('#form-tambah').submit();
                    $('#btn-simpan').addClass('disabled');
                });
                $('#form-tambah').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/anggota/tambah",
                        type:"POST",
                        data:$('#form-tambah').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-tambah').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 2000);
                                setTimeout(function(){$('#modal-tambah').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); refresh_jumlah(); }, 2500);
                            }else{
                                $('#form-pesan-tambah').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 5000);
                            }

                            $('#btn-simpan').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Hapus anggota
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/anggota/hapus",
                        type:"POST",
                        data:$('#form-hapus').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-hapus').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 2000);
                                setTimeout(function(){$('#modal-hapus').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); refresh_jumlah(); }, 2500);
                            }else{
                                $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 5000);
                            }

                            $('#btn-hapus').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Edit anggota
                $('#btn-edit').click(function(){
                    $('#form-edit').submit();
                    $('#btn-edit').addClass('disabled');
                });

                $('#form-edit').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/anggota/edit",
                        type:"POST",
                        data:$('#form-edit').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-edit').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-edit').html('')}, 2000);
                                setTimeout(function(){$('#modal-edit').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); refresh_jumlah(); }, 2500);
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
