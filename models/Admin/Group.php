<?php

namespace Admin;

use \models\Model as Model;

class Group extends Model
{
	public function get_all()
	{
		$db = \DB::get_connection();

		$sql = 'SELECT id, name FROM groups ORDER BY id DESC';

		$query = $db->prepare($sql);

		if ($query->execute()) {		
			$groups = [];

			$i = 0;
			while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
				$groups[$i]['id'] = $row['id'];
				$groups[$i]['name'] = $row['name'];

				$i++;
			}

			return $groups;
		} else {
			return false;
		}

	}

	public function create(array $data)
	{
		$this->validate($data, [
			'name' => 'empty|length'
		]);

		$db = \DB::get_connection();

		$sql = 'INSERT INTO groups (name) VALUES (:name)';

		$query = $db->prepare($sql);
		$query->bindParam(':name', $data['name']);

		return $query->execute();
	}

	public function show(string $id)
	{
		$db = \DB::get_connection();

		$sql = 'SELECT id, name FROM groups WHERE id = :id';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);

		if ($query->execute()) {
			return $query->fetch(\PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	}

	public function update(array $data)
	{
		$this->validate($data, [
			'name' => 'empty|length'
		]);

		$db = \DB::get_connection();

		$sql = 'UPDATE groups SET name = :name WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindParam(':id', $data['id']);
		$query->bindParam(':name', $data['name']);

		if ($query->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function delete(string $id)
	{
		$db = \DB::get_connection();

		$sql = 'DELETE FROM groups WHERE id = :id';

		$query = $db->prepare($sql);

		$query->bindParam(':id', $id);

		if ($query->execute()) {
			return true;
		} else {
			return false;
		}
	}
}