            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        User
                        <small>Manajemen user pada SIM UKM</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">User</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini Anda bisa menambahkan, memodifikasi, dan menghapus user
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
                                        <button class="btn btn-sm btn-success" id="btn-tambah-user"><i class="fa fa-plus">&nbsp;</i> Tambah User</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table-user" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID</th>
                                                <th>UKM</th>
                                                <th>Username</th>
                                                <th>Dibuat</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          foreach($record_user as $row){
                                          ?>
                                            <tr>
                                              <td>
                                                <?php echo $row['NO']?>
                                              </td>
                                              <td>
                                                <?php echo $row['ID']?>
                                              </td>
                                              <td>
                                                <?php echo $row['UKM'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['USERNAME'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['DIBUAT'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['ROLE'] ?>
                                              </td>
                                              <td>
                                                <?php echo $row['STATUS'] ?>
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
                                                <th>UKM</th>
                                                <th>Username</th>
                                                <th>Dibuat</th>
                                                <th>Role</th>
                                                <th>Status</th>
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

        <!-- Modal Tambah User -->
      <div class="modal fade" id="modal-tambah" data-backdrop="static">
          <div class="modal-dialog" style="width: 50%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-user"></i> Tambah User</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-tambah">
                          </span>
                          <?php echo form_open('user/tambahuser', 'id="form-tambah"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Role:</span>
                                              <select class="form-control" id="tambah-role" name="tambah-role">
                                                  <?php
                                                  // $datarole = $this->user_model->get_role();
                                                  if(!empty($datarole)) {
                                                    foreach ($datarole as $key ) {
                                                  ?>
                                                      <option value="<?php echo $key->ROLE_ID;?>"><?php echo $key->ROLE_NAME;?></option>
                                                  <?php } } ?>
                                              </select>

                                          </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Username:</span>
                                              <select class="form-control" id="tambah-username" name="tambah-username">
                                                  <?php
                                                  if(!empty($listnon)) {
                                                    foreach ($listnon as $key )
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
                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">Email:</span>
                                              <input type="email" class="form-control" id="tambah-email" name="tambah-email" placeholder="Email" />
                                          </div><!-- /.input group -->
                                      </div>

                                      <div class="form-group">

                                          <div class="input-group">
                                              <span class="input-group-addon">UKM:</span>
                                              <select class="form-control" id="tambah-ukm" name="tambah-ukm">
                                                  <?php
                                                  if(!empty($dataukm)) {
                                                    foreach ($dataukm as $key ){
                                                  ?>
                                                      <option value="<?php echo $key->UKM_ID;?>"><?php echo $key->UKM_NAME;?></option>
                                                  <?php } } ?>
                                              </select>

                                          </div><!-- /.input group -->
                                      </div>
                                  </div>

                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label>Password :</label>
                                          <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-lock"></i>
                                              </div>
                                              <input type="password" class="form-control" id="tambah-pass" name="tambah-pass" placeholder="Password Min. 5 Karakter" />
                                          </div><!-- /.input group -->

                                          <br>
                                          <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-lock"></i>
                                              </div>
                                              <input type="password" class="form-control" id="tambah-passconf" name="tambah-passconf" placeholder="Konfirmasi Password" />
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

      <!-- Modal Hapus User -->
      <div class="modal fade" id="modal-hapus" data-backdrop="static">
          <div class="modal-dialog" style="width: 350px;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-user"></i> Hapus User</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-hapus">
                          </span>
                          <?php echo form_open('user/hapususer', 'id="form-hapus"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                          <input type="hidden" id="hapus-id" name="hapus-id" />
                                          <input type="hidden" id="hapus-uname" name="hapus-uname" />
                                          <p>Apakah Anda yakin ingin menghapus User berikut ?</p>
                                          <div class="callout callout-info">
                                              <p>Username : <span id="hapus-username"> </span></p>
                                              <p>Role : <span id="hapus-role"> </span></p>
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

      <!-- Modal Edit User -->
      <div class="modal fade" id="modal-edit" data-backdrop="static">
          <div class="modal-dialog" style="width: 30%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-user"></i> Edit User</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-edit">
                          </span>
                          <?php echo form_open('user/edituser', 'id="form-edit"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Username:</span>
                                        <input type="text" class="form-control" id="edit-username" name="edit-username" placeholder="Username min. 3 Karakter" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Email:</span>
                                        <input type="email" class="form-control" id="edit-email" name="edit-email" placeholder="Email" />
                                      </div><!-- /.input group -->
                                    </div>
                                    <div class="form-group">

                                      <div class="input-group">
                                        <span class="input-group-addon">Role:</span>
                                        <select class="form-control" id="edit-role" name="edit-role">
                                          <?php if(!empty($datarole)) { foreach ($datarole as $key ) { ?>
                                            <option value="<?php echo $key->ROLE_ID;?>"><?php echo $key->ROLE_NAME;?></option>
                                            <?php } } ?>
                                          </select>

                                        </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">

                                        <div class="input-group">
                                          <span class="input-group-addon">UKM:</span>
                                          <select class="form-control" id="edit-ukm" name="edit-ukm">
                                            <?php if(!empty($dataukm)) { foreach ($dataukm as $key ) { ?>
                                              <option value="<?php echo $key->UKM_ID;?>"><?php echo $key->UKM_NAME;?></option>
                                              <?php } } ?>
                                            </select>

                                          </div><!-- /.input group -->
                                        </div>
                                        <div class="form-group">
                                          <label>Tanggal Dibuat :</label>
                                          <div class="input-group">
                                            <div class="input-group-addon">
                                              <i class="fa fa-sort-numeric-asc"></i>
                                            </div>
                                            <input type="text" class="form-control" id="edit-tgl" name="edit-tgl" readonly="" />
                                            <input type="hidden" id="edit-id" name="edit-id" readonly="" />
                                            <input type="hidden" id="edit-tempuname" name="edit-tempuname" readonly="" />
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

      <!-- Modal Password -->
      <div class="modal fade" id="modal-password" data-backdrop="static">
          <div class="modal-dialog" style="width: 25%;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title"><i class="fa fa-user"></i> Ganti Password</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-body table-responsive">
                          <span id="form-pesan-password">
                          </span>
                          <?php echo form_open('user/gantipassword', 'id="form-password"') ?>
                          <div class="box-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="form-group">
                                          <div class="input-group">
                                              <span class="input-group-addon">Username:</span>
                                              <input type="text" id="pass-name" name="pass-name" readonly="" class="form-control" />
                                          </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group">
                                          <label>Password Baru :</label>
                                          <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-lock"></i>
                                              </div>
                                              <input type="password" class="form-control" id="pass-baru" name="pass-baru" placeholder="Password Baru" />
                                          </div><!-- /.input group -->
                                          <br>
                                          <div class="input-group">
                                              <div class="input-group-addon">
                                                  <i class="fa fa-lock"></i>
                                              </div>
                                              <input type="password" class="form-control" id="pass-conf" name="pass-conf" placeholder="Konfirmasi Password Baru" />
                                              <input type="hidden" id="pass-id" name="pass-id" readonly="" />
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
                      <button id="btn-simpanpass" type="button" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                  </div>
              </div>
          </div>
      </div> <!-- /.modal-password-->

        <script type="text/javascript">
            function modaledit(id, username, ukm, role, tgl, mail){
                $('#form-pesan-edit').html('');
                $('#edit-id').val('');
                $('#edit-username').val('');
                $('#edit-email').val('');
                $('#edit-tempuname').val('');
                $('#edit-tgl').val('');
                $('#modal-edit').modal('show');
                $('#edit-id').val(id);
                $('#edit-username').val(username);
                $('#edit-email').val(mail);
                $('#edit-tempuname').val(username);
                $("#edit-role option").filter(function(){
                    return ( ($(this).val() == role) || ($(this).text() == role) );
                }).prop('selected', true);
                $("#edit-ukm option").filter(function(){
                  return ( ($(this).val() == ukm) || ($(this).text() == ukm) );
                }).prop('selected', true);
                $('#edit-tgl').val(tgl);
            }

            function modalhapus(id, username, role){
                $('#form-pesan-hapus').html('');
                $('#modal-hapus').modal('show');
                $('#hapus-id').val(id);
                $('#hapus-uname').val(username);
                $('#hapus-username').html(username);
                $('#hapus-role').html(role);
            }

            function modalpass(id, username){
                $('#form-pesan-password').html('');
                $('#pass-baru').val('');
                $('#pass-conf').val('');
                $('#modal-password').modal('show');
                $('#pass-id').val(id);
                $('#pass-name').val(username);

            }

            $(document).ready(function() {
                $("[data-mask]").inputmask();
                $('#modal-tambah').on('shown.bs.modal', function (e) {
                    $('#tambah-username').focus();
                });

                $('#btn-refresh').click(function(){
                   location.reload();
                });

                $('#modal-hapus').on('shown.bs.modal', function (e) {
                    $('#btn-hapus').focus();
                });

                $('#modal-edit').on('shown.bs.modal', function (e) {
                    $('#edit-username').focus();
                });

                $('#modal-password').on('shown.bs.modal', function (e) {
                    $('#pass-lama').focus();
                });

                $('#btn-tambah-user').click(function(){
                    $('#form-pesan-tambah').html('');
                    $('#modal-tambah').modal('show');
                });

                // Edit password
                $('#btn-simpanpass').click(function(){
                    $('#form-password').submit();
                    $('#btn-simpanpass').addClass('disabled');
                });

                $('#form-password').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/user/gantipassword",
                        type:"POST",
                        data:$('#form-password').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-password').html(pesan_succ(obj.pesan));
                                setTimeout(function(){$('#form-pesan-password').html('')}, 2000);
                                setTimeout(function(){$('#modal-password').modal('hide')}, 2500);
                                setTimeout(function(){location.reload() }, 2500);
                            }else{
                                $('#form-pesan-password').html(pesan_err(obj.pesan));
                                setTimeout(function(){$('#form-pesan-password').html('')}, 3000);
                            }
                            $('#btn-simpanpass').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Tambah User
                $('#btn-simpan').click(function(){
                    $('#form-tambah').submit();
                    $('#btn-simpan').addClass('disabled');
                });
                $('#form-tambah').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/user/tambahuser",
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

                            //alert($('#form-tambah').serialize());

                            $('#btn-simpan').removeClass('disabled');
                        }
                    });
                    return false;
                });

                // Hapus counter
                $('#btn-hapus').click(function(){
                    $('#form-hapus').submit();
                    $('#btn-hapus').addClass('disabled');
                });
                $('#form-hapus').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/user/hapususer",
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

                // Edit counter
                $('#btn-edit').click(function(){
                    $('#form-edit').submit();
                    $('#btn-edit').addClass('disabled');
                });

                $('#form-edit').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/user/edituser",
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
            });
        </script>

    </body>
</html>
