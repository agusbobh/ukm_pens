            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reminder
                        <small>Untuk membuat Reminder ke UKM</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url();?>/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Reminder</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- info selamat datang -->
                    <div class="alert alert-info alert-dismissable" style="padding:5px 35px 5px 5px; margin: 0 0 5px 0">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Di halaman ini kamu bisa melihat semua reminder yang telah dikirim dan tentunya membuat reminder baru
                    </div>

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Reminder Terkirim</h3>
                                    <!-- tools -->
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-sm btn-info" id="btn-tambah-reminder"><i class="fa fa-plus">&nbsp;</i> Reminder Baru</button>
                                    </div>
                                    <!-- /.tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody>
                                        <?php
                                        if(!empty($datareminder)) {
                                          foreach ($datareminder as $key) {
                                        ?>
                                        <tr>
                                            <td><span class="label label-<?php echo $key->TIPE_NAMA;?>"><?php echo $key->TEKS ." / " . $key->NOTIF_TIME;?></span> <?php echo substr($key->NOTIF_ACTIVITY,0);?> { <i>dikirim ke <?php echo $key->UKM_NAME;?></i> }.</td>
                                        </tr>
                                        <?php } } else {  ?>
                                        <tr>
                                            <td>Tidak ada Reminder.</td>
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

        <!-- Modal Tambah reminder -->
        <div class="modal fade" id="modal-tambah" tabindex="-999" role="dialog" aria-labelledby="btn-tambah-reminder" aria-hidden="true">
            <div class="modal-dialog" style="width: 350px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-check"></i> Reminder Baru</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body table-responsive">
                            <span id="form-pesan-tambah">
                            </span>
                            <?php echo form_open('reminder/baru', 'id="form-tambah"') ?>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">UKM:</span>
                                                <select class="form-control" id="rem-ukm" name="rem-ukm">
                                                    <?php
                                                      if(!empty($dataukm)) {
                                                        foreach ($dataukm as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->UKM_ID;?>"><?php echo $key->UKM_NAME;?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div><!-- /.input group -->
                                        </div>
                                        <div class="form-group">
                                            <textarea id="rem-teks" name="rem-teks" class="form-control" rows="3" style="overflow:auto;resize:none" placeholder="Pesan Anda"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Tipe:</span>
                                                <select class="form-control" id="rem-tipe" name="rem-tipe">
                                                    <?php
                                                      if(!empty($datatiperem)) {
                                                        foreach ($datatiperem as $key) {
                                                    ?>
                                                    <option value="<?php echo $key->TIPE_ID;?>"> <?php echo $key->TIPE_TEKS;?></option>
                                                    <?php } } ?>
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
                        <button id="btn-simpan" type="button" class="btn btn-primary"><i class="fa fa-envelope"></i> Kirim</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#modal-tambah').on('shown.bs.modal', function (e) {
                    $('#rem-ukm').focus();
                });

                $('#btn-tambah-reminder').click(function(){
                    $('#form-pesan-tambah').html('');
                    $('#rem-teks').val('');
                    $('#modal-tambah').modal('show');
                });

                // Tambah reminder
                $('#btn-simpan').click(function(){
                    $('#form-tambah').submit();
                    $('#btn-simpan').addClass('disabled');
                });
                $('#form-tambah').submit(function(){
                    $.ajax({
                        url:"<?php echo site_url()?>/reminder/baru",
                        type:"POST",
                        data:$('#form-tambah').serialize(),
                        cache: false,
                        success:function(respon){
                            var obj = $.parseJSON(respon);
                            if(obj.status==1){
                                $('#form-pesan-tambah').html(pesan_succ('Reminder berhasil dikirim !'));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 2000);
                                setTimeout(function(){$('#modal-tambah').modal('hide')}, 2500);
                                setTimeout(function(){ location.reload(); }, 2500);
                            }else{
                                $('#form-pesan-tambah').html(pesan_err(obj.error));
                                setTimeout(function(){$('#form-pesan-tambah').html('')}, 5000);
                            }

                            $('#btn-simpan').removeClass('disabled');
                        }
                    });
                    return false;
                });
            });
        </script>

    </body>
</html>
