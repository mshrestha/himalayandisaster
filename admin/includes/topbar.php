<?php echo "<div class='hidden'>" . $_SESSION[ 'name'] . "</div>"; if($_SESSION[ 'name']): $role=$_SESSION[ 'userrole']; /* 1=admin 2=warehousers 3=super volunteer */ $page=$_SESSION[ 'page']; global $config;?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container container-topbar">
        <div class="navbar-header">


            <a class="navbar-brand" href="<?php echo $config['homeUrl']  ?>/admin"><i class="fa fa-heart"></i> Himalayan Disaster</a>

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">

                <?php if($role !=3 ): ?>
                <li>
                    <a href="addEditItems.php" <?php if($page=='item' ) echo 'class="active"';?>>Items</a>
                </li>
                <?php endif; ?>

                <?php if($role !=2 ): ?>

                <li class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Missions <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          
          <ul class="">
                        <li><a href="/admin/listPackage.php" <?php if($page=='listpackage' ) echo 'class="active"';?>>List Missions</a>
                        </li>
                        <li><a href="/admin/addPackage.php" <?php if($page=='addpackage' ) echo 'class="active"';?>>Create Missions</a>
                        </li>
                    </ul>
        </div>
                </li>

                <?php endif; ?>
                <li><a href="registeredVolunteers.php" <?php if($page=='volunteer-reg' ) echo 'class="active"';?>> Volunteer</a>
                </li>
                <li><a href="helpRequests.php" <?php if($page=='helprequest' ) echo 'class="active"';?>>Help Requests</a>
                </li>

                <?php if($role !=2 ): ?>
                <li class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin <span class="caret"></span>
        </a>
                    
                    <ul class="" >
                        <li><a href="addEditWareHouse.php" <?php if($page=='warehouse' ) echo 'class="active"';?>>WareHouses</a>
                        </li>
                        <li><a href="addEditStockType.php" <?php if($page=='stock' ) echo 'class="active"';?>>Stock Categories</a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Management</li>
                        <li><a href="addEditUser.php" <?php if($page=='user' ) echo 'class="active"';?>>Add User</a>
                        </li>
                        <li><a href="reports.php" <?php if($page=='reports' ) echo 'class="active"';?>>Reports</a>
                        </li>

                    </ul>
                </li>

                <?php endif; ?>
                <li><a href="<?php echo $config['adminController'];?>/indexController.php?action=logout">Logout</a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<section data-ng-view="" id="content" class="animate-fade-up ng-scope">
    <div class="page page-general ng-scope">
        <div class="container theme-showcase" role="main">
            <div class="row">
                <div class="col-md-12">
                    <?php else: echo "<p class='text-center'>Enter your Username and Password </p>"; endif; ?>
