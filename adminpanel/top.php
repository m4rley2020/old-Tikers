<?php include("linkvars.php"); ?>
<header class="header navbar navbar-fixed-top" role="banner">  <!-- Start: Header and Nav Bar -->

        <div class="container"> <!-- Start: Nav Bar Container -->

            <ul class="nav navbar-nav"> <!-- Start: Mobile Menu toggle -->
                <li class="nav-toggle">
                    <a href="javascript:void(0);" title="">
                        <i class="fa fa-bars"></i>
                    </a>
                </li 
            </ul>   <!-- End Mobile Menu toggle -->

            <a class="navbar-brand" href="deskboard.php">  <!-- Start: Logo -->
                <img src="images/logo.png" alt="logo"/>
                <strong>Welcome</strong>  <?php echo $_COOKIE['UsErOfAdMiN']; ?>
            </a>    <!-- End Logo -->

            <a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
                <i class="fa fa-bars"></i>
            </a>    <!-- End : Desktop Main Menu Toggler -->
            
          <ul class="nav navbar-nav navbar-left hidden-xs hidden-sm"> <!-- Start : Top Left Drop down -->
                <li><a href="deskboard.php">Dashboard</a></li>
                
                <?php 
                     for($i=0;$i<count($HeadLinksArray);$i++)
                            {
                                ?>
                               <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                         <?php echo $HeadLinksArray[$i][0]; ?> <i class="fa fa-angle-down"></i>
                                     </a>
                               
                                    <ul class="dropdown-menu">
                                         <?php

                                                 $LeftLinkAry1 = $HeadLinksArray[$i][2];
                                                 for($LeftLinkCount=0;$LeftLinkCount<count($LeftLinkAry1);$LeftLinkCount++)
                                                 {
                                                         $destop_count++;
                                                 ?>


                                                 <li>
                                                      <a href="<?php echo $LeftLinkAry1[$LeftLinkCount][1] ?>">
                                                               <i class="fa fa-tasks"></i><?php echo $LeftLinkAry1[$LeftLinkCount][0] ?>
                                                               </a>
                                                 </li>  

                                                 <?php          
                                                 }
                                            ?>
                                    </ul>
                             </li> 
                                       <?php
                            }
                    ?>
                
            </ul>   <!-- End : Top Left Drop down -->

            <ul class="nav navbar-nav navbar-right">    <!-- Start : Top Right Drop down Menu -->

                <li class="dropdown user">  <!-- Start : User Drop Down -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img class="userImg" src="images/avatar-1.png">
                        <span class="username"><?php echo $_COOKIE['UsErOfAdMiN']; ?></span>
                        <i class="fa fa-angle-down small"></i>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="changepass.php">
                                <i class="fs-user"></i> My Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="logout.php">
                                <i class="fa fa-power-off"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </li>   <!-- End : User Drop Down -->

            </ul>   <!-- End : Top Right Drop down Menu -->

        </div>  <!-- End Nav Bar Container -->

    </header>   <!-- End Header and Nav Bar -->