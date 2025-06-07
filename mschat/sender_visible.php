<?
session_start();
require_once("common.php");
?>	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-right:230px;">
		<tr><td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" class="str_send">
				<tr height="20">
					<td width="20">
						<button onclick="clearForm()" class="btn btn-danger btn-small btn-primary" style="margin-top:3px;"><i class="icon-trash icon-white" style="margin-top:2px;"></i></button>
						<form action='sender.php' method='post' onSubmit="addMes(); return false;">
					</td>
					<td>
						<input type="text" id="text" name="text" style="color:<? if($prof['color'] != "#ffffff") echo $prof['color'];?>;" class="input sender_text" maxlength='500' placeholder="Сообщение">
					</td>
					<td width="180" align="right">
						<button onclick="" title='Enter' class="btn btn-warning"><i class="icon-envelope icon-white" style="margin-top:2px;"></i> Всем</button>
						<button onclick="addMes(1);" title='Отправить сообщение приватно' class="btn btn-info">Приват</button>
						&nbsp;
						</form>						
					</td>
				</tr>
			</table>
			
			
			<table width="100%" cellpadding="0" cellspacing="0" border="0"  class="str_send">
				<tr height="35">
					<td width="30">
						<button onclick="clearFrom()" class="btn btn-danger btn-small btn-primary" style="margin-top:3px;"><i class="icon-trash icon-white" style="margin-top:2px;"></i></button>
					</td>
					<td width="140">
						<input type="text" id="from" class="input sender_text" name="from" placeholder="Кому">
					</td>
					<td width="120">
						
						<div class="clear" onclick="onClear()">
							<div class="ch" id="clear"></div> Очищать
						</div>
					</td>
					<td width="<? if($prof['gradient'] > time())echo "140"; else echo "100";?>">
						<!---->
						<select id="colors"></select>			
						<input type="hidden" id="onClear">
						<!---->
							<div id="color">
								<p id="titletop">Выбор цвета</p>
								<div class="closeColor"><img src="<?=$image_url;?>closeMiniWhite.png" onClick="closeColor()" class="pointer" title="Закрыть"></div>
								<div id="colors_menu">
									<? include("inc/color.php"); ?>
								</div>
							</div>
							
							<?//градиент
							if($prof['gradient'] > time()){ 
								if(!$prof['color_grad'])$prof['color_grad'] = "#000000";
								?>
								<div id="color_grad">
									<p id="titletop">Выбор цвета</p>
									<div class="closeColor"><img src="<?=$image_url;?>closeMiniWhite.png" onClick="closeColor()" class="pointer" title="Закрыть"></div>
									<div id="colors_menu">
										<?php
										$grad = 1;
										include("inc/color.php");
										?>
									</div>
								</div>

								<div class="sender_check1 pointer" onClick="color();" title="Первый цвет градиента"><div id="id_color" style="background-color:<?=$prof['color'];?>"></div></div>
								<div class="sender_check2 pointer" onClick="color(1);" title="Второй цвет градиента"><div id="id_color1" style="background-color:<?=$prof['color_grad'];?>"></div></div>
								<div class="sender_check3 pointer" onclick="alert('Нижмите на цветовые кнопки чтобы задать цвет градиента (левее от надписи градиент). Срок годности градиента истекает <?=date("j.m.Y в H:i",$prof['gradient']);?>, чтобы продлить купите еще раз градиент в магазине и Вам добавятся до существующих еще 30 дней.');" title="Действителен до <?=date("j.m.Y",$prof['gradient']);?>">Градиент</div>
								
							
							<?}else{ //Цвета ?>
											
								<div class="sender_check pointer" id="color_menu" onClick="color();"><div id="id_color" style="background-color:<?=$prof['color'];?>"></div> Цвет</div>
							
							<?}?>
					</td>
					<td width="100">
						<div class="sender_check pointer" id="smile_menu" onClick="smile();"><img src="<?=$image_url;?>smile.png" id="id_smile">  Смайлы</div>
					</td>
					<td width="100">
						<div class="sender_check pointer" id="status_menu" onClick="status();"><img src="<?=$status_id;?>" id="id_status"> Статус</div>
					</td>
					
					<td>&nbsp;</td>
					<? if($_SESSION['admin']){?>
						<td>
							<button class="moder_butt" onclick="ban(1);">Бан</button>
							<button class="moder_butt" onclick="ban(2);">Затнуть</button>
							<button class="moder_butt" onclick="ban(3);">Пред.</button>
							<button class="moder_butt" onclick="ban(4);">Обьяв.</button>
						</td>
					<?}?>
				</tr>
			</table>
			</td>
		</tr>
		<tr height="10"></tr>
	</table>