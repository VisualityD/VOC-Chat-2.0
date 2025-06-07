<?php
session_start();
header("Content-type: text/html;charset=utf-8");
require_once("../common.php");
require_once("../connect.php");
$inc = 1;
?>
<!DOCTYPE html>
<html>
  <head>	
	<link rel="stylesheet" href="<?=$css_url;?>bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>all.css" type="text/css" />
	<link rel="stylesheet" href="<?=$css_url;?>pages.css" type="text/css" />
	
	<title>Нововведения | <?=$conf['chatname'];?></title>
	<? include("../copy_image.php");?>
</head>
<body>
<? include("../top.php");?>	
	<div id="main">
		<div id="m_left">
			<div class="m_top">Меню</div>
			<?php include("../menu.php");?>
		</div>		
		<div id="m_right">
			<div class="m_top">Что нового?</div>
			
			<div id="shop_load">
				<!--Оформление-->
				<div class="text">
					<p>
						<ul>
						
							<li><span class="date">15.06.2013</span>
								<div class="news">
									Чат открыт для посетителей. Зарегестрировано первые 20 человек из них 8 активировали email. Отправлено более 500 сообщений
								</div>
							</li>
							
							<hr>
							<li><span class="date">16.06.2013</span>
								<div class="news">
									- Переделан дизайн и функционал проверок на странице регистрации. Введены ограничения по выбору
									ника для чата. Теперь можно использовать только английские буквы, цифры, тире и символ подчеркивания.
									<div class="author">Автор: <a href="<?php echo $conf['url']; ?>id1" target="_blank">Skriptoff</a></div>
									- Дописаны подробные правила для сайта и добавлена ссылка на них при регистрации и при загрузке фотографий. 
									<div class="author">Автор: <a href="<?php echo $conf['url']; ?>id2" target="_blank">jule4ka</a></div>
									- Добавлен звуковое оповещание о новом сообщении когда свернут приват. 
									<div class="author">Автор идеи: <a href="<?php echo $conf['url']; ?>id20" target="_blank">lona_ok</a></div>
								
								</div>
							</li>
							
							<hr>
							<li><span class="date">18.06.2013</span>
								<div class="news">
									- Доработана постраничная навигация в профилях, как дизайн так и функционал.
									<div class="author">Автор: <a href="<?php echo $conf['url']; ?>id1" target="_blank">Skriptoff</a></div>
									- Установлена и настроена статистика чата. Пока показывает сколько <a href="http://socfriends.ru/pages/statistic.php?msgs" target="_blank">сообщений в день</a> и  <a href="http://socfriends.ru/pages/statistic.php?online" target="_blank">пользователей онлайн</a>
									<div class="author">Автор: <a href="<?php echo $conf['url']; ?>id1" target="_blank">Skriptoff</a></div>
								</div>
							</li>
							
							<hr>
							<li><span class="date">19.06.2013</span>
								<div class="news">
									- Звуковой сигнал о новом приватном сообщении срабатывает теперь не только когда свернут приват, но и когда акошко с чатом не активно (свернуто).
									<div class="author">Автор: <a href="<?php echo $conf['url']; ?>id1" target="_blank">Skriptoff</a></div>
								</div>
							</li>
							
							
							
						</ul>
					</p>
				</div>
			</div>
		</div>
	<? include("../copy.php");?>
</body>
</html>