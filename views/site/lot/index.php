<?php require_once(ROOT . '/views/layouts/header.php'); ?>
	<main class="main-content">
		<section class="section">
			<div class="grid-body">
			<div class="grid-content">
			<div class="grid-1-2">
				<?php if ($lots): ?>
					<?php foreach($lots as $lot): ?>
						<div class="auction-card__full">
							<div class="auction-card__full-header">
								<div class="auction-card__full-img">
									<img src="/public/image/icon/lots/barrel.svg">
								</div>
								<div class="auction-card__full-title">
									<div class="auction-card__full-title-text">
										<?php print $lot['name']; ?>
									</div>
									<div class="auction-card__full-info">
										<div class="auction-card__full-info-user">
											<!-- 5 участников -->
										</div>
										
									</div>

									<div class="auction-card__full-info">
										<div class="auction-card__full-info-user">
											<!-- 5 участников -->
										</div>
										<div class="auction-card__full-info-price">количество: <?php print $lot['count']; ?> тонн.</div>
									</div>
								</div>
							</div>

					<div class="auction-card__full-timer">
						<div id="timeStartText" class="auction-card__full-timer-name"></div>
						<div class="auction-card__full-timer-count">
							<div id="startTimer"></div>
							<div id="timer" class="active"></div>
							<div class="auction-card__full-timer-finish">
								<?php 
									$datetime = explode(' ', $lot['stop']);
									// $date = preg_replace('/-/', '.', $datetime[0]);
									$parts_stop_date = explode('-', $datetime[0]);
									$date = $parts_stop_date[2] . '.' . $parts_stop_date[1] . '.' . $parts_stop_date[0];
									$time =  substr($datetime[1], 0, 5);
								?>
								до <?php print $time . ' ' . $date; ?>
							</div>
						</div>
					</div>

					<div class="auction-card__full-price">
						<div class="auction-card__full-price-name">Стартовая цена</div>
						<div id="startPrice" style="display: none;">
							<?php print $lots[0]['price']; ?>
						</div>
						<div id="startPriceSum" class="auction-card__full-price-value"></div>
						<span class="value-type">руб.</span>
					</div>

						<div class="auction-card__full-bet bet__hide">
							<?php if ($lots[0]['status'] == 1): ?>
								<div class="auction-card__full-bet-value">
									<div class="auction-card__full-bet-value-change">
										<div class="remove">-</div>
										<div id="lastBet" style="display: none">                          
											<?php $last_bet = reset($bets); ?>
											<?php if ($last_bet): ?>
												<?php print $last_bet['bet']; ?>
											<?php else: ?>
												<?php print $lots[0]['price']; ?>
											<?php endif; ?>
										</div>
										<div class="betCount"></div>
										<input class="bet-sum" type="hidden" step="<?php print $lot['step_bet']; ?>">
										<div class="add">+</div>
									</div>
									<div class="auction-card__full-bet-value-error">
										<p class="error-bet"><p>
									</div>
								</div>
							<?php endif; ?>
							<div class="auction-card__full-bet-button">
								<form class="bet" action="/bet/create" name="messages" method="POST">
							    	<input type="hidden" name="lot_id" value="<?php print $lot['id'] ?>">
							    	<input type="hidden" name="lot_status" value="<?php print $lot['status'] ?>">
							        <input type="hidden" name="user_id" value="<?php print $_SESSION['user']; ?>">
							        <input type="hidden" name="user_login" value="<?php print $_SESSION['user_login']; ?>">
							        <input type="hidden" name="user_email" value="<?php print $_SESSION['user_email']; ?>">
							        <input type="hidden" name="date_bet" value="<?php print date('H:i d.m.Y'); ?>">
							        <input type="hidden" name="previous_bet">
							        <input type="hidden" name="bet">
							        <?php if ($lots[0]['status'] == 1): ?>
										<button type="submit" class="button button-color button-round">Сделать ставку</button>
									<?php endif; ?>
							    </form>
							</div>
						</div>
				</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
				<div id="userId" style="display: none"><?php print $_SESSION['user']; ?></div>
				<div id="userName" style="display: none"><?php print $_SESSION['user_login']; ?></div>

				<!-- Start -->
				<div id="yearStartAuction" style="display: none;"><?php print $year_start; ?></div>
				<div id="mounthStartAuction" style="display: none;"><?php print $mounth_start; ?></div>
				<div id="dayStartAuction" style="display: none;"><?php print $day_start; ?></div>
				<div id="timeStartAuction" style="display: none;"><?php print $time_start; ?></div>

				<!-- Stop -->
				<div id="yearStopAuction" style="display: none;"><?php print $year_stop; ?></div>
				<div id="mounthStopAuction" style="display: none;"><?php print $mounth_stop; ?></div>
				<div id="dayStopAuction" style="display: none;"><?php print $day_stop; ?></div>
				<div id="timeStopAuction" style="display: none;"><?php print $time_stop; ?></div>


				<?php $lotchars = explode(", ", $lot['characteristics']); ?>

				<ul class="characteristics-list">
					<li class="characteristics-list--item--title">
						<h3 class="characteristics-list--item--title-text">Характеристики товара</h3>
						<ul class="characteristics-list--item-content">
							<?php foreach($lotchars as $lotchar): ?>
								<li class="characteristics-list--item-content-text"><?php print $lotchar; ?></li>
							<?php endforeach; ?>
						</ul>
					</li>

					<li class="characteristics-list--item--title">
						<h3 class="characteristics-list--item--title-text">Условия оплаты</h3>
						<ul class="characteristics-list--item-content">
							<?php foreach($lots as $lot): ?>
								<li class="characteristics-list--item-content-text"><?php print $lot['conditions_payment'] ?></li>
							<?php endforeach; ?>
						</ul>
					</li>

					<li class="characteristics-list--item--title">
						<h3 class="characteristics-list--item--title-text">Условия отгрузки</h3>
						<ul class="characteristics-list--item-content">
							<?php foreach($lots as $lot): ?>
								<li class="characteristics-list--item-content-text"><?php print $lot['conditions_shipment'] ?></li>
							<?php endforeach; ?>
						</ul>
					</li>

					<li class="characteristics-list--item--title">
						<h3 class="characteristics-list--item--title-text">Сроки отгрузки</h3>
						<ul class="characteristics-list--item-content">
							<?php foreach($lots as $lot): ?>
								<li class="characteristics-list--item-content-text"><?php print $lot['terms_shipment'] ?></li>
							<?php endforeach; ?>
						</ul>
					</li>

					<li class="characteristics-list--item--title">
						<h3 class="characteristics-list--item--title-text">Способ перевозки</h3>
						<ul class="characteristics-list--item-content">
							<li class="characteristics-list--item-content-text">Перевозка осуществляется авто либо жд транспортом.</li>
						</ul>
					</li>
				</ul>

			</div>

			<div class="grid-1-2">
				<div class="section-title">Последние ставки</div>
				<table class="table">
					<thead class="table-header">
						<th class="table-align-left">Участник</th>
						<th class="table-align-center">Последняя цена</th>
						<th class="table-align-right">Дата</th>
					</thead>
					<tbody id="history-bets">
						<?php foreach ($bets as $bet): ?>
							<tr class="bet table-item user-bet-item" data-user-login="<?php print $bet['user_login']; ?>" data-user-id="<?php print $bet['user_id']; ?>">
								<td class="table-align-left"><?php print $bet['user_login']; ?></td>
								<td class="table-align-center">
									<div class="user-bet-value" style="display: none;"><?php print $bet['bet']; ?></div>
									<div class="user-bet"></div> руб.
									<span class="user-bet-count"></span>
								</td>
								<?php 
									$datetime = explode(' ', $bet['create_date']);
									// $date = preg_replace('/-/', '.', $datetime[0]);
									$parts_create_date = explode('-', $datetime[0]);
									$date = $parts_create_date[2] . '.' . $parts_create_date[1] . '.' . $parts_create_date[0];
									$time =  substr($datetime[1], 0, 5);
								?>
								<td class="table-align-right"><?php print $time . ' ' . $date; ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</main>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>