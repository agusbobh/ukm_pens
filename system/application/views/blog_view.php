<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url();?>system/public/assets/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo base_url();?>system/public/assets/frontend/img/ico/apple-touch-icon.html">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url();?>system/public/assets/frontend/img/ico/apple-touch-icon-72x72.html">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>system/public/assets/frontend/img/ico/apple-touch-icon-114x114.html">
    <title>//SIM UKM PENS</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>system/public/assets/front/css/bootstrap.css" rel="stylesheet">
 <!-- Fontawesome core CSS -->
    <link href="<?php echo base_url();?>system/public/assets/front/css/font-awesome.min.css" rel="stylesheet" />
     <!--GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
      <!-- Timeline -->
    <link href="<?php echo base_url();?>system/public/assets/front/css/timeline.css" rel="stylesheet" />
     <!-- custom CSS here -->
    <link href="<?php echo base_url();?>system/public/assets/front/css/style.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="#">YOUR LOGO </a> -->
                    <img src="<?php echo base_url();?>system/public/assets/img/avatar10.png" height="50px" class="img-circle" alt="User Image"/>
            </div>
            <!-- Collect the nav links for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Home</a>
                    </li>
                    <li><a href="<?php echo site_url();?>/login">Login</a>
                    </li>
                    <li><a href="#">About</a>
                    </li>
                    <li><a href="#">Services</a>
                    </li>
                    <li><a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
       <div class="container" >
            <div class="row ">

                <div class="col-md-offset-2 col-md-8 col-sm-12 top-margin" >
                    <div >
                        <ul class="timeline">
                            <li class="time-label">
                                <span class="bg-orange">Timeline Agenda Kegiatan UKM di PENS
                                </span>
                                <br />
                                <br />
                            </li>
                            <?php
                            //var_dump($dataagenda);
                              if (!empty($dataagenda)) {
                                foreach($dataagenda as $row ) {
                            ?>
                            <li class="time-label">
                                <span class="bg-light-blue">
                                  <?php echo $row->UKM_NAME ?>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-envelope bg-black"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i><?php echo $row->AGENDA_TIME ?>  s/d  <?php echo $row->AGENDA_TIMETO ?></span>
                                    <h3 class="timeline-header text-navy"><?php echo $row->AGENDA_TITLE ?></h3>
                                    <div class="timeline-body">
                                      <?php
                                          echo $row->AGENDA_TEXT
                                      ?>
                                    </div>
                                    <!-- <div class='timeline-footer'>
                                        <a class="btn btn-primary btn-xs">Share</a>
                                        <a class="btn btn-danger btn-xs">Read More</a>
                                    </div> -->
                                </div>
                            </li>
                            <?php } } ?>
                            <li>
                                <i class="fa fa-clock-o"></i>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>

        </div>
        <li>
            <a class="fa fa-angle-up" href="" title="Kembali Ke Atas"></a>
        </li>
    <!-- /.container -->

   <!--Core JavaScript file  -->
    <script src="<?php echo base_url();?>system/public/assets/front/js/jquery-1.10.2.js"></script>
    <!--bootstrap JavaScript file  -->
    <script src="<?php echo base_url();?>system/public/assets/front/js/bootstrap.js"></script>
</body>
</html>
