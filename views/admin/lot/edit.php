<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
	<div class="main__content">	
	<form class="ajax-form" action="/lot/update" method="POST">
		<input type="hidden" name="lot_id" value="<?php isset($lot['id']) ? print $lot['id'] : ''; ?>">
			<label>Название:</label>
			<input type="text" name="name" value="<?php isset($lot['name']) ? print $lot['name'] : ''; ?>">

			<br>
			<br>
			<br>
			<label>Характеристики:</label>

			<?php 
				$characteristics = explode(',', $lot['characteristics']);
			?>

			<input type="text" name="characteristics[]" value="<?php isset($characteristics[0]) ? print $characteristics[0] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[1]) ? print $characteristics[1] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[2]) ? print $characteristics[2] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[3]) ? print $characteristics[3] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[4]) ? print $characteristics[4] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[5]) ? print $characteristics[5] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[6]) ? print $characteristics[6] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[7]) ? print $characteristics[7] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[8]) ? print $characteristics[8] : print ''; ?>">
			<input type="text" name="characteristics[]" value="<?php isset($characteristics[9]) ? print $characteristics[9] : print ''; ?>">

			<br>
			<br>
			<br>

			<label>Цена:</label>
			<input type="number" name="price" value="<?php isset($lot['price']) ? print $lot['price'] : ''; ?>" min="1">

			<label>Группы:</label>
			<select class="js-example-basic-multiple" multiple="multiple" name="groups[]">
				<option value="0"></option>

				<?php foreach ($groups as $group): ?>
					<?php $selected = ''; ?>
					<?php foreach ($lot_groups as $lot_group): ?>
					
						<?php if ($group['id'] == $lot_group['id']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>
					<?php endforeach; ?>

					<option <?php print $selected; ?> value="<?php print $group['id'] ?>"><?php print $group['name'] ?></option>
				<?php endforeach; ?>
			</select>

			<label>Шаг ставки:</label>
			<input type="number" name="step_bet" value="<?php isset($lot['step_bet']) ? print $lot['step_bet'] : ''; ?>" min="1">
			
			<label>Колличество:</label>
			<input type="number" name="count" value="<?php isset($lot['count']) ? print $lot['count'] : ''; ?>" min="1">

			<label>Условия оплаты:</label>
			<input type="text" name="conditions_payment" value="<?php isset($lot['conditions_payment']) ? print $lot['conditions_payment'] : ''; ?>">

			<label>Условия отгрузки:</label>
			<input type="text" name="conditions_shipment" value="<?php isset($lot['conditions_shipment']) ? print $lot['conditions_shipment'] : ''; ?>">

			<label>Сроки отгрузки:</label>
			<input type="text" name="terms_shipment" value="<?php isset($lot['terms_shipment']) ? print $lot['terms_shipment'] : ''; ?>">

			<label>Начало аукциона:</label>
			<input class="datetimepicker" type="text" name="start" value="<?php isset($lot['start']) ? print $lot['start'] : ''; ?>">

			<label>Конец аукциона:</label>
			<input class="datetimepicker" type="text" name="stop" value="<?php isset($lot['stop']) ? print $lot['stop'] : ''; ?>">

			<label>Статус:</label>
			<select name="status">
				<option <?php ($lot['status'] == 1) ? print 'selected' : print ''; ?> value="1">Активировать</option>
				<option <?php ($lot['status'] == 2) ? print 'selected' : print ''; ?> value="2">Деактивировать</option>
				<option <?php ($lot['status'] == 3) ? print 'selected' : print ''; ?> value="3">В архив</option>
			</select>

		<button type="submit">Обновить</button>
		<a href="/lots">Отмена</a>
	</form>
</div>

<?php require ROOT . '/views/layouts/footer.php'; ?>