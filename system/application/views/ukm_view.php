            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        UKM
                        <small>Manajemen UKM pada SIM UKM</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= echo site_url('dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">UKM</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini Anda bisa menambahkan, memodifikasi, dan menghapus UKM
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
                                        <button class="btn btn-sm btn-success" id="btn-tambah-ukm"><i class="fa fa-plus">&nbsp;</i> Tambah UKM</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table-ukm" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Kontak</th>
                                                <th>Dibuat</th>
                                                <th>Info</th>
                                                <th>Status</th>
                                                <th>Pembina</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          foreach($record_ukm as $row){
                                          ?>
                                            <tr>
                                              <td>
                                                <?php echo $row['NO']?>
                                              </td>
                                              <td>
                                                <?php echo $row['ID']?>
                                              </td>
                                              <td>
                                                <?php echo $row['NAMA'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['KONTAK'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['DIBUAT'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['INFO'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['STATUS'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['PEMBINA'] ?>
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
                                              <th>No</th>
                                              <th>ID</th>
                                              <th>Nama</th>
                                              <th>Kontak</th>
                                              <th>Dibuat</th>
                                              <th>Info</th>
                                              <th>Status</th>
                                              <th>Pembina</th>
                                              <th>Opsi</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div>
                        </section><!-- /.Left col -->

                    </div><!-- /.row (main row) -->


                </section><!-- /.content -->

            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- Modal Tambah UKM -->
      <div class="modal fade" id="modal-tambah" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sitemap"></i> Tambah UKM</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-tambah">
                          </span>
                          <?php echo form_open('ukm/tambahukm', 'id="form-tambah"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Nama UKM :</span>
                                              <input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Nama UKM min. 3 Karakter" />
                                          </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Kontak :</span>
                                              <input type="text" class="form-control" id="tambah-kontak" name="tambah-kontak" placeholder="Kontak untuk dihubungi" />
                                          </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Nama Pembina :</span>
                                              <select class="form-control" id="tambah-pembina" name="tambah-pembina">
                                                  <option value="Tidak Ada">Tidak Ada</option>
                                                  <?php
                                                  if(!empty($listpegawai)) {
                                                    foreach ($listpegawai as $key )
                                                    {
                                                  ?>
                                                      <option value="<?php echo $key->NAMA;?>"><?php echo $key->NAMA;?></option>
                                                  <?php
                                                    }
                                                  }
                                                  ?>
                                              </select>

                                          </div><!-- /.input group -->
                                      </div>
                                  </div>

                              </div>
                          </div>
                          <?php echo form_close(); ?>
                      </div><!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-simpan" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
              </div>
          </div>
      </div>

      <!-- Modal Hapus UKM -->
      <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 26%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sitemap"></i> Hapus UKM</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('ukm/hapusukm', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <input type="hidden" id="hapus-id" name="hapus-id" />
                                          <input type="hidden" id="hapus-nama" name="hapus-nama" />
                                          <p>Apakah Anda yakin ingin menghapus UKM berikut ?</p>
                                          <div class="callout callout-info">
                                              <p>Nama UKM : <span id="hapus-namaukm"> </span></p>
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

      <!-- Modal Edit UKM -->
      <div class="modal fade" id="modal-edit" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sitemap"></i> Edit UKM</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-edit">
                          </span>
                          <?php echo form_open('ukm/editukm', 'id="form-edit"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Nama UKM    :</span>
                                        <input type="text" class="form-control" id="edit-nama" name="edit-nama" placeholder="Nama UKM min. 3 Karakter" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Kontak    :</span>
                                        <input type="email" class="form-control" id="edit-kontak" name="edit-kontak" placeholder="Kontak untuk dihubungi" />
                                      </div><!-- /.input group -->
                                    </div>
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Nama Pembina  :</span>
                                              <select class="form-control" id="edit-pembina" name="edit-pembina">
                                                  <?php
                                                  if(!empty($listpegawai)) {
                                                    foreach ($listpegawai as $keys )
                                                    {
                                                  ?>
                                                      <option value="<?php echo $keys->NAMA;?>"><?php echo $keys->NAMA;?></option>
                                                  <?php
                                                    }
                                                  }
                                                  ?>
                                              </select>

                                          </div><!-- /.input group -->
                                      </div>
                                        <div class="form-group">
                                          <label>Tanggal Dibuat   :</label>
                                          <div class="input-group">
                                            <div class="input-group-addon">
                                              <i class="fa fa-sort-numeric-asc"></i>
                                            </div>
                                            <input type="text" class="form-control" id="edit-tgl" name="edit-tgl" readonly="" />
                                            <input type="hidden" id="edit-id" name="edit-id" readonly="" />
                                            <input type="hidden" id="edit-tempnama" name="edit-tempnama" readonly="" />
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

      <!-- Modal Perbarui Info -->
      <div class="modal fade" id="modal-info" data-backdrop="static">
          <div class="modal-dialog" style="width: 25%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-sitemap"></i> Perbarui Info</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-info">
                          </span>
                          <?php echo form_open('ukm/updateinfo', 'id="form-info"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">Info:</span>
                                              <input type="hidden" id="info-id" name="info-id" readonly="" />
                                              <input type="text" id="info-teks" name="info-teks" placeholder="Info UKM" class="form-control" />
                                          </div><!-- /.input group -->
                                      </div>

                                  </div>
                              </div>
                          </div>
                          <?php echo form_close(); ?>
                      </div><!-- /.box-body -->
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                      <button id="btn-simpaninfo" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
              </div>
          </div>
      </div> <!-- /.modal-password-->

        <script type="text/javascript">
            function modaledit(id, nama, kontak, pembina, tgl){
                $('#form-pesan-edit').html('');
                $('#edit-id').val('');
                $('#edit-nama').val('');
                $('#edit-kontak').val('');
                $('#edit-pembina').val('');
                $('#edit-tempnama').val('');
                $('#edit-tgl').val('');
                $('#modal-edit').modal('show');
                $('#edit-id').val(id);
                $('#edit-nama').val(nama);
                $('#edit-kontak').val(kontak);
                $('#edit-pembina').val(pembina);
                $('#edit-tempnama').val(nama);
                $("#edit-pembina option").filter(function(){
                    return ( ($(this).val() == pembina) || ($(this).text() == pembina) );
                }).prop('selected', true);
                $('#edit-tgl').val(tgl);
            }

            function modalhapus(id, nama){
                $('#form-pesan-hapus').html('');
                $('#modal-hapus').modal('show');
                $('#hapus-id').val(id);
                $('#hapus-nama').val(nama);
                $('#hapus-namaukm').html(nama);
            }

            function modalinfo(id){
                $('#form-pesan-info').html('');
                $('#info-teks').val('');
                $('#modal-info').modal('show');
                $('#info-id').val(id);
            }

            function resizeWindow(e){
                var newWindowWidth = $(window).width();
                var oTable = $('#table-data').dataTable();
                if(newWindowWidth > 1024){
                        // Do Something
                    oTable.fnSetColumnVis( 2, true );
                    oTable.fnSetColumnVis( 4, true );
                }else if((newWindowWidth >= 600) && (newWindowWidth <= 1050)){
                        // Do Something
                    oTable.fnSetColumnVis( 2, false );
                    oTable.fnSetColumnVis( 4, false );
                }else if(newWindowWidth < 600){

                }
            }


            $(document).ready(function() {
                $("[data-mask]").inputmask();
                $('#modal-tambah').on('shown.bs.modal', function (e) {
                    $('#tambah-nama').focus();
                });

                $('#modal-hapus').on('shown.bs.modal', function (e) {
                    $('#btn-hapus').focus();
                });

                $('#btn-refresh').click(function(){
                  location.reload();
                });

                $('#modal-edit').on('shown.bs.modal', function (e) {
                    $('#edit-nama').focus();
                });

                $('#modal-info').on('shown.bs.modal', function (e) {
                    $('#info-teks').focus();
                });

                $('#btn-tambah-ukm').click(function(){
                    $('#form-pesan-tambah').html('');
                    $('#modal-tambah').modal('show');
                });

                // perbarui info
                $('#btn-simpaninfo').click(function(){
                    $('#form-info').submit();
                    $('#btn-simpaninfo').addClass('disabled');
                });

                $('#form-info').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/ukm/updateinfo",
                        type:"POST",
                        data:$('#form-info').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-info').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-info').html('')}, 2000);
                                setTimeout(function(){$('#modal-info').modal('hide')}, 2500);
                                setTimeout(function(){location.reload()}, 2500);
                            }else{ss
                                $('#form-pesan-info').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-info').html('')}, 3000);
                            }
                            $('#btn-simpaninfo').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Tambah UKM
                $('#btn-simpan').click(function(){
                    $('#form-tambah').submit();
                    $('#btn-simpan').addClass('disabled');
                });
                $('#form-tambah').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/ukm/tambahukm",
                        type:"POST",
                        data:$('#form-tambah').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-tambah').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 2000);
                                setTimeout(function(){$('#modal-tambah').modal('hide')}, 2500);
                                setTimeout(function(){location.reload()}, 2500);
                            }else{
                                $('#form-pesan-tambah').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 5000);
                            }
                            $('#btn-simpan').removeClass('disabled');
                        }



                    });
                    return false;
                });

                // Hapus UKM
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/ukm/hapusukm",
                        type:"POST",
                        data:$('#form-hapus').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-hapus').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 2000);
                                setTimeout(function(){$('#modal-hapus').modal('hide')}, 2500);
                                setTimeout(function(){location.reload()}, 2500);
                            }else{
                                $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-hapus').html('')}, 5000);
                            }

                            $('#btn-hapus').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Edit UKM
                $('#btn-edit').click(function(){
                    $('#form-edit').submit();
                    $('#btn-edit').addClass('disabled');
                });

                $('#form-edit').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/ukm/editukm",
                        type:"POST",
                        data:$('#form-edit').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-edit').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-edit').html('')}, 2000);
                                setTimeout(function(){$('#modal-edit').modal('hide')}, 2500);
                                setTimeout(function(){location.reload()}, 2500);
                            }else{
                                $('#form-pesan-edit').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-edit').html('')}, 2000);
                            }

                            $('#btn-edit').removeClass('disabled');
                        }
                    });
                    return false;
                });
                $(window).bind("resize", resizeWindow);
                resizeWindow();
            });

        </script>

    </body>
</html>
