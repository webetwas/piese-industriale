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

		<p>Content</p>

		<?=$page["page"]->content_ro;?>
    <table align="center">
      <thead>
        <th>Companie</th>
        <th>WWW - Website</th>
        <th>E-mail</th>
        <th>Telefon</th>
        <th>Locatie</th>
      </thead>
      <tbody>
        <tr>
          <td style="padding:10px;"><?=$owner->td_company;?></td>
          <td style="padding:10px;"><?=$owner->td_website;?></td>
          <td style="padding:10px;"><?=$owner->td_email;?></td>
          <td style="padding:10px;"><?=$owner->td_phone;?></td>
          <td style="padding:10px;"><?=$owner->td_location;?></td>
        </tr>
      </tbody>
    </table>
	</div>

</div>
