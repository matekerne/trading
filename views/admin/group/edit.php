<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
	<form class="ajax-form" action="/group/update" method="POST">
		<input type="hidden" name="id" value="<?php print $group['id']; ?>">
		<label>Имя:</label>
		<input type="text" name="name" value="<?php isset($group['name']) ? print $group['name'] : '';  ?>">

		<button type="submit">Обновить</button>
		<a href="/groups">Отмена</a>
	</form>
</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>