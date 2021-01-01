<div id="sidebar" class="sidebar-fixed">    <!-- Start : Side bar -->

            <div id="sidebar-content">  <!-- Start : Side bar content -->
                
                <ul id="nav">   <!-- Start : Side bar Menu Items -->
                    
                    <li class="current open">
                        <a href="deskboard.php">
                            <i class="fa fa-dashboard"></i> Dashboard <span class="selected"></span>
                        </a>
                    </li>

                   <?php 
                     for($i=0;$i<count($HeadLinksArray);$i++)
                            {
                                ?>
                               <li>
                               <a href="javascript:void(0);">
                                   <i class="fa fa-desktop"></i><?php echo $HeadLinksArray[$i][0]; ?>
                                </a>
                               <ul class="sub-menu">
                                    <?php

                                            $LeftLinkAry1 = $HeadLinksArray[$i][2];
                                            for($LeftLinkCount=0;$LeftLinkCount<count($LeftLinkAry1);$LeftLinkCount++)
                                            {
                                                    $destop_count++;
                                            ?>


                                            <li>
                                                 <a href="<?php echo $LeftLinkAry1[$LeftLinkCount][1] ?>">
                                                          <i class="fa fa-desktop"></i><?php echo $LeftLinkAry1[$LeftLinkCount][0] ?>
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

                    

                    
                </ul>   <!-- End : Side bar Menu Items -->
                
            </div>  <!-- End : Side bar content -->

        </div>  <!-- End : Side bar -->