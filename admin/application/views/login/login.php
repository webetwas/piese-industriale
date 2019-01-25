<?php
// var_dump($application);die();
?>

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h2 class="logo-name"><?=$application->owner->td_company;?></h2>

            </div>
            <p><?=$application->owner->about;?>
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p>Intra in cont</p>
						<p><?=(isset($error) ? '<label style="color:red">'.$error. '</label>' : "")?></p>
            <form class="m-t" role="form" action="<?=base_url();?>login/getin" id="lgetin" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Utilizator" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Parola" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                
            </form>
            <p class="m-t"> <small>&copy; <?=date('Y');?> <?=$application->owner->td_company;?></small> </p>
        </div>
    </div>