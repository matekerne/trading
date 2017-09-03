<?php require ROOT . '/views/layouts/header.php'; ?>

<main class="main-content">
	<section class="section">
		<div class="grid-body grid-bg">
			<div class="grid-content">
				<div class="grid-fix-medium">
					<form class="ajax-form" action="/user/create" method="POST">

						<input type="hidden" name="user_id">
						
						<input type="text" name="login" value="" placeholder="Логин">
					
						<input type="password" name="password" value="" placeholder="Пароль">
					
						<input type="text" name="name" value="" placeholder="Имя">
					
						<input type="text" name="email" value="" placeholder="Email">

						<select class="js-example-basic-multiple" multiple="multiple" name="groups[]">

							<?php foreach($groups as $group): ?>
								<option value="<?php print $group['id'] ?>"><?php print $group['name'] ?></option>
							<?php endforeach; ?>
						</select>
						
						<button class="button button-color button-round create_user" type="submit">Создать</button>
					</form>
				</div>
			<div class="grid-expand">
			<div class="user-list">
				<table class="table">
					<thead class="table-header">
					<th class="table-align-left">Логин</th>
					<th>Имя</th>
					<th>Эл. почта</th>
					<th>Группа</th>
					<th class="table-align-right"></th>
					</thead>
				<tbody>
			<?php foreach($users as $user): ?>
				<tr id="<?php print $user['id']?>" class="table-item user-item">
					
					<td><?php print $user['login']?></td>
					<td class="table-align-center"><?php print $user['name']?></td>
					<td class="table-align-center"><?php print $user['email']?></td>
					<td class="table-align-center"><?php print $user['groups']?></td>
					<td class="table-align-right">
						<a href="#" class="button button-icon__small edit_user"><img src="../public/image/icon/pencil.svg"></a>
						<a href="#" class="button button-icon__small delete_user"><img src="../public/image/icon/delete.svg"></a>

					</td>

					<!--<form class="ajax-form" action="/user/delete" method="POST">
						<input type="hidden" name="user_id" value="<?php /*print $user['id'] */?>">
						<button type="submit">Удалить</button>
					</form>-->
				</tr>
			<?php endforeach; ?>
					</tbody>
					</table>
			</div>
			</div>
			</div>

		</div>
	</section>
</main>

<?php require ROOT . '/views/layouts/footer.php'; ?>