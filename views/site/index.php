<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<main class="main-content">
	<section class="section">
		<div class="grid-body">
		<!-- <div class="section-title">Какой-то вводный текст про аукцион</div> -->
			<div class="grid-content">
				<?php foreach($lots as $lot): ?>
					<div class="grid-1-4">
						<div class="auction-card">
							<div class="auction-card-img">
								<img src="/public/image/icon/lots/barrel.svg">
							</div>
							<div class="auction-card-title padding-15"><?php print $lot['name']; ?></div>
							<div class="auction-card-price padding-15">
								<span class="price-text">Стартовая цена</span>
								<div class="card-price">
									<span id="startLotPrice" style="display: none;"><?php print $lot['price']; ?></span>
									<span id="startLotCost" class="card-lot-cost"></span>
									<span>руб.</span>
								</div>
							</div>

							<div class="auction-card-price padding-15">
								<span class="price-text">Текущая цена</span>
								<div class="card-price">
									<span id="currentCost" style="display: none;">
										<?php $bets = $bet->get_all_by_each_lot($lot['id']); ?>
										<?php $last_bet = reset($bets); ?>
										<?php if ($last_bet): ?>
											<?php print $last_bet['bet']; ?>
										<?php else: ?>
											<?php print $lot['price']; ?>
										<?php endif; ?>
									</span>
									<span id="currentLotCost" class="card-lot-cost"></span> 
									<span>руб.</span>
								</div>
							</div>
							<div class="auction-card-timer padding-10"></div>
							<div class="auction-card-link">
								<a href="/lot/<?php print $lot['id']; ?>" class="button button-color button-round">Принять участие</a>
							</div>
							<?php 
								$datetime = explode(' ', $lot['stop']);
								$date = preg_replace('/-/', '.', $datetime[0]);
								$time =  substr($datetime[1], 0, 5);
							?>
							<div class="auction-card-date">до <?php print $time . ' ' . $date; ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<!-- 	<section class="section">
		<div class="grid-body">
		<div class="section-title">Архив аукционов</div>
			<table class="table">
				<thead class="table-header">
					<th>Наименование товара</th>
					<th>Победитель</th>
					<th>Финальная цена</th>
					<th>Дата</th>
				</thead>
				<tbody>
					<tr class="table-item">
						<td>Цистерна нефти</td>
						<td>Matekerne</td>
						<td>10000</td>
						<td>31-08-2017</td>
					</tr>
					<tr class="table-item">
						<td>Цистерна нефти</td>
						<td>Matekerne</td>
						<td>10000</td>
						<td>31-08-2017</td>
					</tr>
					<tr class="table-item">
						<td>Цистерна нефти</td>
						<td>Matekerne</td>
						<td>10000</td>
						<td>31-08-2017</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section> -->
</main>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>