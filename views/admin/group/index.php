<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<main class="main-content">
	<section class="section">
		<div class="grid-body grid-bg">
			<div class="grid-content">
				<div class="grid-fix-medium">
					<form class="ajax-form" action="/group/create" method="POST">
						<input type="hidden" name="id">
						<input type="text" name="name" value="" placeholder="Имя">

						<button class="button button-color button-round create_group" type="submit">Создать</button>
					</form>
				</div>
				<div class="grid-expand">
					<table class="table">
						<thead class="table-header">
							<th class="table-align-left">Имя</th>
							<th></th>
						</thead>
						<tbody>
						<?php foreach($groups as $group): ?>
							<tr id="<?php print $group['id'] ?>" class="table-item">
								<td class="table-align-left">
									<p><?php print $group['name']?></p>
								</td>
								<td class="table-align-right">
									<a href="#" class="button button-icon__small edit_group"><img src="public/image/icon/pencil.svg"></a>
									<a href="#" class="button button-icon__small delete_group"><img src="public/image/icon/delete.svg"></a>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</section>
</main>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>