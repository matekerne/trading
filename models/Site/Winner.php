<?php

namespace Site;

use \models\Model as Model;

class Winner extends Model
{
	public function create(array $data)
	{
		$db = \DB::get_connection();

		$sql = 'SELECT lot_id FROM winners WHERE lot_id = :lot_id';

		$query = $db->prepare($sql);

		$query->bindParam(':lot_id', $data['lot_id']);
		$query->execute();

		if (!$query->fetch(\PDO::FETCH_ASSOC)) {
			$sql = 'INSERT INTO winners (lot_id, user_id) VALUES (:lot_id, :user_id)';

			$query = $db->prepare($sql);

			$query->bindParam(':lot_id', $data['lot_id']);
			$query->bindParam(':user_id', $data['user_id']);

			return $query->execute();
		} else {
			return true;
		}
	}
}