<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<main class="main-content">
	<section class="section">
		<div class="grid-body grid-bg">
			<div class="grid-content grid-content__column">
				<div class="grid-fix-medium">
					<form class="ajax-form" action="/lot/create" method="POST">
						<input type="hidden" name="lot_id">
						<label>Название</label>
						<input type="text" name="name" value="" placeholder="Название">
						<div class="characteristics_list">
							<label>Характеристики</label>
							<input type="text" name="characteristics[]" placeholder="Введите характеристики">
							<div class="button button-color button-round add_characteristics">Добавить</div>
						</div>
						<label>Цена</label>
						<input type="number" name="price" value="" min="1" placeholder="Цена">
						<label>Тип цены</label>
						<input type="text" name="price_type" placeholder="Тип цены (руб/тонна, евро/кг)">

						<select class="js-example-basic-multiple" multiple="multiple" name="groups[]">
							<option value=""></option>
							<?php foreach($groups as $group): ?>
								<option value="<?php print $group['id'] ?>"><?php print $group['name'] ?></option>
							<?php endforeach; ?>
						</select>
						<label>Шаг ставки</label>
						<input type="number" name="step_bet" value="" min="1" placeholder="Шаг ставки">
						<label>Количество</label>
						<input type="number" name="count" value="" min="1" placeholder="Количество">
						<label>Тип количества</label>
						<input type="text" name="count_type" placeholder="Тип колличества (тонн, кг и т.п.)">
						<label>Условия оплаты</label>
						<input type="text" name="conditions_payment" value="" placeholder="Условия оплаты">
						<label>Условия отгрузки</label>
						<input type="text" name="conditions_shipment" value="" placeholder="Условия отгрузки">
						<label>Сроки отгрузки</label>
						<input type="text" name="terms_shipment" value="" placeholder="Сроки отгрузки">
						<label>Начало аукциона</label>
						<input class="datetimepicker" type="text" name="start" placeholder="Начало аукциона">
						<label>Конец аукциона</label>
						<input class="datetimepicker" type="text" name="stop" placeholder="Конец аукциона">

						<select name="status" class="status-lot">
							<option value="1">Активный</option>
							<option value="2">Неактивный</option>
						</select>

						<button class="button button-color button-round lot_update" type="submit">Создать</button>
					</form>
				</div>
				<div class="grid-expand lot-list">
					<table class="table">
						<thead class="table-header">
							<th class="table-align-left">Имя</th>
							<th>Группы</th>
							<th>Количество</th>
							<th>Цена</th>
							<th>Шаг ставки</th>
							<th></th>
						</thead>
						<tbody>
							<?php foreach($lots as $lot): ?>
								<tr class="table-item" id="<?php print $lot['id']; ?>">
									<td class="table-align-left table-collapse"><?php print $lot['name']; ?></td>
									<td class="table-align-center"><?php print preg_replace('/[0-9]+/', '', $lot['groups']); ?></td>
									<td class="table-align-center"><?php print $lot['count']; ?><span><?php print $lot['count_type']; ?></span></td>
									<td class="table-align-center"><?php print $lot['price']; ?><span><?php print $lot['price_type']; ?></span></td>
									<td class="table-align-center"><?php print $lot['step_bet']; ?></td>
									<td class="table-align-right">
										<a href="#" class="button button-icon__small edit_lot"><img src="../public/image/icon/pencil.svg"></a>
										<a href="#" class="button button-icon__small delete_lot"><img src="../public/image/icon/delete.svg"></a>
									</td>

								</tr>

								<?php $lotchars = explode(", ", $lot['characteristics']); ?>

								<tr class="table-collapse-item">
									<td colspan="6">
										<table class="table-nested">
											<tbody>
												<tr>
													<td class="table-nested-col-3">
														Характеристики
														<ul class="char-list">
															<?php foreach($lotchars as $lotchar): ?>
																<li class="char-list-item"><?php print $lotchar; ?></li>
															<?php endforeach; ?>
														</ul>
													</td>
													<td class="table-nested-col-3">
														Условия оплаты
														<p><?php print $lot['conditions_payment']; ?></p>
													</td>
													<td class="table-nested-col-3">
														Условия отгрузки:
														<p><?php print $lot['conditions_shipment']; ?></p>

														Сроки отгрузки:
														<p><?php print $lot['terms_shipment']; ?></p>
													</td>
												</tr>
											</tbody>
										</table>

									</td>

								</tr>

							<?php endforeach; ?>
						</tbody>
					</table>
					<?php /*foreach($lots as $lot): */?><!--
						<label>Имя:</label>
						<p><?php /*print $lot['name']; */?></p>

						<label>Характеристики:</label>
						<p><?php /*print $lot['characteristics']; */?></p>

						<label>Цена:</label>
						<p><?php /*print $lot['price']; */?></p>

						<label>Тип цены:</label>
						<p><?php /*print $lot['price_type']; */?></p>

						<label>Колличество:</label>
						<p><?php /*print $lot['count']; */?></p>

						<label>Тип колличества:</label>
						<p><?php /*print $lot['count_type']; */?></p>

						<label>Условия оплаты:</label>
						<p><?php /*print $lot['conditions_payment']; */?></p>

						<label>Условия отгрузки:</label>
						<p><?php /*print $lot['conditions_shipment']; */?></p>

						<label>Сроки отгрузки:</label>
						<p><?php /*print $lot['terms_shipment']; */?></p>

						<label>Шаг ставки:</label>
						<p><?php /*print $lot['step_bet']; */?></p>

						<label>Группы:</label>
						<p><?php /*print preg_replace('/[0-9]+/', '', $lot['groups']); */?></p>

						<form class="ajax-form" action="/user/notify" method="POST">
							<input type="hidden" name="groups" value="<?php /*print preg_replace('/[^0-9,]+/', '', $lot['groups']); */?>">
							<button style="display: none" type="submit">Оповестить участников</button>
						</form>

						<a href="/lot/edit/<?php /*print $lot['id']; */?>">Редактировать</a>
						
						<form class="ajax-form" action="/lot/delete" method="POST">
							<input type="hidden" name="lot_id" value="<?php /*print $lot['id']; */?>">
							<button type="submit">Удалить</button>
						</form>
						<br>
					--><?php /*endforeach; */?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>