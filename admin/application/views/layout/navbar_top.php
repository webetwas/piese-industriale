<?php
// var_dump($calendar);
?>
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
				
            <ul class="nav navbar-top-links navbar-left">
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="<?=base_url();?>platforma/setari/utilizator/item/u/id/<?=$application->user->id;?>">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Revizuieste adresa de E-mail
                                    <span class="pull-right text-muted small">Contul meu</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>				
				
            <ul class="nav navbar-top-links navbar-right">
                <!--<li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>-->
				<?php if($application->user->privilege):?>
                <li>
                    <a href="<?=base_url()?>legaturi">
                        <i class="fa fa-cogs" style="color:#1c84c6;"></i> Legaturi
                    </a>
                </li>
				<?php endif; ?>
                <li>
                    <a href="<?=base_url();?>platforma/setari/companie/item/u/id/<?=$application->owner->id;?>">
                        <i class="fa fa-user-circle" style="color:#1ab394;"></i> Contul meu
                    </a>
                </li>
                <li>
                    <a href="<?=base_url();?>login/getout">
                        <i class="fa fa-sign-out" style="color:red;"></i> Iesire
                    </a>
                </li>
            </ul>

        </nav>
        </div>