<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Penggajian</title>
        <!-- Bootstrap -->
        <link href="<?php echo $base; ?>public/template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="<?php echo $base; ?>public/template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="<?php echo $base; ?>public/template/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- iCheck -->
        <link href="<?php echo $base; ?>public/template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- bootstrap-progressbar -->
        <link href="<?php echo $base; ?>public/template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
        <!-- JQVMap -->
        <link href="<?php echo $base; ?>public/template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
        <!-- bootstrap-daterangepicker -->
        <link href="<?php echo $base; ?>public/template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <!-- Datatables -->
        <link href="<?php echo $base; ?>public/template/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $base; ?>public/template/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $base; ?>public/template/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $base; ?>public/template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $base; ?>public/template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
        <!-- Datatables -->
        <!-- Custom Theme Style -->
        <link href="<?php echo $base; ?>public/template/build/css/custom.min.css" rel="stylesheet">

        <!-- JQuery UI -->
        <link rel="stylesheet" href="<?php echo $base; ?>public/plugin/jquery-ui-1.12.1.custom/jquery-ui.css">

        <link rel="stylesheet" media="all" type="text/css" href="<?php echo $base; ?>public/plugin/jQuery-Timepicker/dist/jquery-ui-timepicker-addon.css" />
    </head>
    <!-- jQuery -->
    <script src="<?php echo $base; ?>public/template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $base; ?>public/template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="#" class="site_title"><i class="fa fa-home"></i> <span>Sistem Penggajian</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <img src="<?php echo $base; ?>public/template/production/images/img.jpg" alt="..." class="img-circle profile_img">
                            </div>
                            <div class="profile_info">
                                <span>Welcome</span>
                                <!-- keterangan nama dari session yang dibentuk ketika login berhasil -->
                                <h2><?php echo $this->session->userdata('ses_name'); ?></h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
						
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>&nbsp;<nr/></h3>

                                <ul class="nav side-menu">
                                   <?php if($role=='Administrator'){
									 $this->load->view('template/sidemenu_admin');  
								   }else if($role=='HRD'){
									    $this->load->view('template/sidemenu_hrd');
								   }else if($role=='HOD'){
									    $this->load->view('template/sidemenu_hod');
								   }
								   ?>
                                    
                                </ul>
                            </div>             
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a href="<?php echo site_url('c_login/logout') ?>" data-toggle="tooltip" data-placement="top" title="Logout">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <!-- keterangan nama dari session yang dibentuk ketika login berhasil -->
                                        <img src="<?php echo $base; ?>public/template/production/images/img.jpg" alt=""><?php echo $this->session->userdata('ses_name'); ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">      
                                        <li><a href="<?php echo site_url('c_login/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>               
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div id="contentdata">
                        <div align="right"><h4>Welcome To Payroll System</h4></div>

                    </div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Template responvise
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- FastClick -->
        <script src="<?php echo $base; ?>public/template/vendors/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?php echo $base; ?>public/template/vendors/nprogress/nprogress.js"></script>
        <!-- Chart.js -->
        <script src="<?php echo $base; ?>public/template/vendors/Chart.js/dist/Chart.min.js"></script>
        <!-- gauge.js -->
        <script src="<?php echo $base; ?>public/template/vendors/gauge.js/dist/gauge.min.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="<?php echo $base; ?>public/template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo $base; ?>public/template/vendors/iCheck/icheck.min.js"></script>
        <!-- Skycons -->
        <script src="<?php echo $base; ?>public/template/vendors/skycons/skycons.js"></script>
        <!-- Flot -->
        <script src="<?php echo $base; ?>public/template/vendors/Flot/jquery.flot.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/Flot/jquery.flot.pie.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/Flot/jquery.flot.time.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/Flot/jquery.flot.stack.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/Flot/jquery.flot.resize.js"></script>
        <!-- Flot plugins -->
        <script src="<?php echo $base; ?>public/template/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/flot.curvedlines/curvedLines.js"></script>
        <!-- DateJS -->
        <script src="<?php echo $base; ?>public/template/vendors/DateJS/build/date.js"></script>
        <!-- JQVMap -->
        <script src="<?php echo $base; ?>public/template/vendors/jqvmap/dist/jquery.vmap.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="<?php echo $base; ?>public/template/vendors/moment/min/moment.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

        <!-- Datatables -->
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-api/fnReloadAjax.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-api/fnStandingRedraw.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/jszip/dist/jszip.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?php echo $base; ?>public/template/vendors/pdfmake/build/vfs_fonts.js"></script>   
        <!-- Datatables -->

        <!-- Custom Theme Scripts -->
        <script src="<?php echo $base; ?>public/template/build/js/custom.min.js"></script>

        <!--JQuery Ui -->
        <script src="<?php echo $base; ?>public/plugin/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>public/plugin/jQuery-Timepicker/dist/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>public/plugin/jQuery-Timepicker/dist/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>public/plugin/jQuery-Timepicker/dist/jquery-ui-sliderAccess.js"></script>
        <script type="text/javascript">

                                                /*mulai setting url default */
                                                var ROOT = {
                                                    'site_url': '<?php echo site_url(); ?>',
                                                    'base_url': '<?php echo base_url(); ?>',

                                                };
                                                /* selesai setting url default */


                                                /* fungsi untuk pindah halaman terhadap menu yang di klik, dan mengakses controllernya */
                                                function ToController(controller, title) {
                                                    var content, url;
                                                    content = $('#contentdata');
                                                    url = ROOT.site_url + '/' + controller;
                                                    $('#Modalloading').modal('show');
                                                    content.load(url);
                                                    $('#Modalloading').modal('hide');
                                                    //content.fadeOut("slow", "linear");
                                                    //content.fadeIn("slow");
                                                    return false;
                                                    url.empty();
                                                }

                                                /* fungsi untuk meload data ketika tombol di halama grid di klik tombolnya*/
                                                function load_form(url, title) {
                                                    var content;
                                                    content = $("#contentdata");
                                                    // content.fadeOut("slow", "linear");
                                                    $('#Modalloading').modal('show');
                                                    content.load(url);
                                                    $('#Modalloading').modal('hide');
                                                    // content.fadeIn("slow");
                                                }




        </script>    

        <style>
            #Modalloading {
                top:40% !important;
                transform: translate(0, -40%) !important;
                -ms-transform: translate(0, -40%) !important;
                -webkit-transform: translate(0, -40%) !important;                
            }
        </style>
        <!-- Modal -->
        <div class="modal fade " id="Modalloading" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog transbox">                  
                <div class="modal-body" align="center">
                    <img class=""  src="<?php echo $base; ?>public/images/loading.gif"  width="200" height="200"/>
                </div>                  
            </div>
        </div>

    </body>
</html>
