<!-- Left Sidebar -->
    <div class="left main-sidebar">
    
        <div class="sidebar-inner leftscroll">

            <div id="sidebar-menu">
        
                <ul>

                        <li class="submenu">
                            <a href="<?php echo base_url('index.php/admin') ?>"><i class="fa fa-fw fa-home"></i><span> Dashboard </span> </a>
                        </li>

                        <li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-list-alt"></i> <span> Navigation Pane  </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('index.php/admin/listFolder') ?>"><i class="fa fa-fw fa-arrow-circle-o-right"></i>List Folder</a></li>
                                <li><a href="<?php echo base_url('index.php/admin/addParents') ?>"><i class="fa fa-fw fa-arrow-circle-o-right"></i>New Parents Folder</a></li>
                                <li><a href="<?php echo base_url('index.php/admin/addChild') ?>"><i class="fa fa-fw fa-arrow-circle-o-right"></i>New Child Folder</a></li>
                            </ul>
                        </li>

                        <?php if($auth_department == 'MIS'){ ?>

                        <li class="submenu">
                        <a href="#"><i class="fa fa-fw fa-key"></i> <span> Add User Permission  </span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled">
                                <li><a href="<?php echo base_url('index.php/admin/listPermission') ?>"><i class="fa fa-fw fa-arrow-circle-o-right"></i>List User</a></li>
                                <li><a href="<?php echo base_url('index.php/admin/addPermission') ?>"><i class="fa fa-fw fa-arrow-circle-o-right"></i>New User</a></li>
                            </ul>
                        </li>

                         <?php } ?>
                        
                </ul>

            </div>
            
            <div class="clearfix"></div>
            
            <div class="clearfix"></div>

        </div>

    </div>
    <!-- End Sidebar -->