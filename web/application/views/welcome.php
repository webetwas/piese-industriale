<div id="container">
	<h2>Welcome to <strong style="color:#3465a4;"><?=$owner->td_owner;?></strong> > Web.framework</span></h2>
	<h1>Visit us: <a href="http://<?=$owner->td_website;?>" target="_blank"><?=$owner->td_website;?></a></h1>

	<div id="body">
		<p>Pages</p>
		<?php
			if(is_null($pageslist)) echo "Nu exista pagini!";
			else {
				foreach($pageslist as $pagel) {
					echo '<code><a href="' .base_url().$pagel->id_page. '">' .$pagel->title. '</a></code>';
				}
			}
		?>
		<p>Methods</p>
		<code><a href="pentest">Pentest</a></code>
		<code><a href="pentest/metweb">Pentest>metweb</a></code>
		<code><a href="pentest/sendemail">Pentest>sendemail</a></code>

		<p>Content</p>

		<?=$page["page"]->content_ro;?>
	</div>

</div>
