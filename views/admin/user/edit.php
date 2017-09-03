<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
	<div class="main__content">
	<form class="ajax-form" action="/user/update" method="POST">
		<input type="hidden" name="user_id" value="<?php print $user['id']; ?>">
		<label>Логин:</label>
		<input type="text" name="login" value="<?php isset($user['login']) ? print $user['login'] : ''; ?>">

		<label>Имя:</label>
		<input type="text" name="name" value="<?php isset($user['name']) ? print $user['name'] : '';  ?>">

		<label>Группы:</label>
		<select class="js-example-basic-multiple" multiple="multiple" name="groups[]">
			<option value="0"></option>

			<?php foreach ($groups as $group): ?>
				<?php $selected = ''; ?>
				<?php foreach ($user_groups as $user_group): ?>
				
					<?php if ($group['id'] == $user_group['id']): ?>
						<?php $selected = 'selected'; ?>
					<?php endif; ?>
				<?php endforeach; ?>

				<option <?php print $selected; ?> value="<?php print $group['id'] ?>"><?php print $group['name'] ?></option>
			<?php endforeach; ?>
		</select>

		<label>Email:</label>
		<input type="text" name="email" value="<?php isset($user['email']) ? print $user['email'] : '';  ?>">

		<label>Пароль:</label>
		<input type="password" name="password">

		<button type="submit">Обновить</button>
		<a href="/users">Отмена</a>
	</form>
</div>

<?php require ROOT . '/views/layouts/footer.php'; ?>