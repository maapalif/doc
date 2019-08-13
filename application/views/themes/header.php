<!-- top bar navigation -->
    <div class="headerbar">

        <!-- LOGO -->
        <div class="headerbar-left" style="background-color: #1e7e34
;">
            <a href="<?php echo base_url('index.php/tree/') ?>" class="logo">
                <img alt="Logo" src="<?php echo base_url() ?>assets/images/favicon.ico" />
          <!-- logo for regular state and mobile devices -->
                 <span class="logo-lg"><b>Documentation</b></span>
            </a>
        </div>

        <nav class="navbar-custom" style="background-color: #1e7e34
;">
            
                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item dropdown notif">
                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?php echo base_url() ?>assets/images/avatars/admin.png" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Hello, <?php echo $auth_username ?></small> </h5>
                                </div>

                                <!-- item-->
                                <a href="<?php echo base_url('index.php/home/logout') ?>" class="dropdown-item notify-item">
                                    <i class="fa fa-power-off"></i> <span>Logout</span>
                                </a>
                                
                            </div>
                        </li>

                    </ul>

        </nav>

    </div>
    <!-- End Navigation -->