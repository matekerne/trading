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
										<div class="auction-card__full-info-price">стартовая цена: <?php print $lot['price']; ?> руб.</div>
									</div>
								</div>
							</div>

					<div class="auction-card__full-timer">
						<div class="auction-card__full-timer-name">Осталось времени</div>
						<div class="auction-card__full-timer-count">
							<div id="timer"></div>
							<div class="auction-card__full-timer-finish">
								<?php 
									$datetime = explode(' ', $lot['stop']);
									$date = preg_replace('/-/', '.', $datetime[0]);
									$time =  substr($datetime[1], 0, 5);
								?>
								до <?php print $time . ' ' . $date; ?>
							</div>
						</div>
					</div>

					<div class="auction-card__full-price">
						<div class="auction-card__full-price-name">Текущая цена</div>
						<div id="lastBet" class="auction-card__full-price-value">
							<?php $last_bet = reset($bets); ?>
							<?php if ($last_bet): ?>
								<?php print $last_bet['bet']; ?>
							<?php else: ?>
								<?php print $lots[0]['price']; ?>
							<?php endif; ?>
						</div>
						<span>руб.</span>
					</div>

					<div class="auction-card__full-bet">
						<div class="auction-card__full-bet-value">
							<div class="auction-card__full-bet-value-change">
								<div class="remove">-</div>
								<input class="bet-sum" type="number" step="<?php print $lot['step_bet']; ?>">
								<div class="add">+</div>
							</div>
							<div class="auction-card__full-bet-value-error">
								<p class="error-bet"><p>
							</div>
						</div>
						<div class="auction-card__full-bet-button">
							<form class="bet" action="/bet/create" name="messages" method="POST">
						    	<input type="hidden" name="lot_id" value="<?php print $lot['id'] ?>">
						    	<input type="hidden" name="lot_status" value="<?php print $lot['status'] ?>">
						        <input type="hidden" name="user_id" value="<?php print $_SESSION['user']; ?>">
						        <input type="hidden" name="user_login" value="<?php print $_SESSION['user_login']; ?>">
						        <input type="hidden" name="user_email" value="<?php print $_SESSION['user_email']; ?>">
						        <input type="hidden" name="date_bet" value="<?php print date('H:i d.m.Y'); ?>">
						        <input type="hidden" name="bet">
								<button type="submit" class="button button-color button-round">Сделать ставку</button>
						    </form>
						</div>
					</div>
					
				</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
				<div id="userId" style="display: none"><?php print $_SESSION['user']; ?></div>
				<div id="userName" style="display: none"><?php print $_SESSION['user_login']; ?></div>
				<div id="yearStopAuction" style="display: none;"><?php print $year; ?></div>
				<div id="mounthStopAuction" style="display: none;"><?php print $mounth; ?></div>
				<div id="dayStopAuction" style="display: none;"><?php print $day; ?></div>
				<div id="timeStopAuction" style="display: none;"><?php print $time; ?></div>

				<div id="yearStartAuction" style="display: none;"><?php print $yearStart; ?></div>
				<div id="mounthStartAuction" style="display: none;"><?php print $mounthStart; ?></div>
				<div id="dayStartAuction" style="display: none;"><?php print $dayStart; ?></div>
				<div id="timeStartAuction" style="display: none;"><?php print $timeStart; ?></div>

				<?php $lotchars = explode(", ", $lot['characteristics']); ?>

				<ul class="characteristics-list">
					<li class="characteristics-list--item">
						<h3 class="characteristics-list--item-title">Характеристики товара</h3>
						<div class="characteristics-list--item-content">
							<?php foreach($lotchars as $lotchar): ?>
								<p class="characteristics-list--item-content-text"><?php print $lotchar; ?></p>
							<?php endforeach; ?>
						</div>
					</li>
					<li class="characteristics-list--item">
						<h3 class="characteristics-list--item-title">Условия доставки и оплаты</h3>
						<div class="characteristics-list--item-content">
							<p class="characteristics-list--item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
							<p class="characteristics-list--item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, quibusdam?</p>
						</div>
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
							<tr class="bet table-item" data-user-email="<?php print $bet['user_email']; ?>" data-user-login="<?php print $bet['user_login']; ?>" data-user-id="<?php print $bet['user_id']; ?>">
								<td class="table-align-left"><?php print $bet['user_login']; ?></td>
								<td class="table-align-center"><?php print $bet['bet']; ?> руб.</td>
								<?php 
									$datetime = explode(' ', $bet['create_date']);
									// $date = preg_replace('/-/', '.', $datetime[0]);
									$parts_date = explode('-', $datetime[0]);
									$date = $parts_date[2] . '.' . $parts_date[1] . '.' . $parts_date[0];
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