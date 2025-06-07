			<?php if (isset($_SESSION['id'])) {?>
				<a class="p_menu" href="<?php echo $conf['url']; ?>id<?=$_SESSION['id'];?>"><i class="icon-user"></i> &nbsp; Моя страница</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>id<?=$_SESSION['id'];?>"><i class="icon-plus"></i> &nbsp; Мои друзья</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>ls.php"><i class="icon-envelope"></i> &nbsp; Мои сообщения</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>profile.php"><i class="icon-cog"></i> &nbsp; Настройки</a>
				
				<hr>
				<a class="p_menu" href="<?php echo $conf['url']; ?>index.php"><i class="icon-home"></i> &nbsp; На главную</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/new.php"><i class="icon-list-alt"></i> &nbsp; Что нового?</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/rules.php"><i class="icon-flag"></i> &nbsp; Правила</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/statistic.php?msgs"><i class="icon-signal"></i> &nbsp; Статистика</a>
			<?}else{?>
				<a class="p_menu" href="<?php echo $conf['url']; ?>index.php"><i class="icon-home"></i> &nbsp; На главную</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>regestration.php"><i class="icon-plus-sign"></i> &nbsp; Регистрация</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>index.php"><i class="icon-ok"></i> &nbsp; Авторизация</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>all.php"><i class="icon-search"></i> &nbsp; Люди / поиск</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/new.php"><i class="icon-list-alt"></i> &nbsp; Что нового?</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/rules.php"><i class="icon-flag"></i> &nbsp; Правила</a>
				<a class="p_menu" href="<?php echo $conf['url']; ?>pages/statistic.php?msgs"><i class="icon-signal"></i> &nbsp; Статистика</a>
			<?}?>