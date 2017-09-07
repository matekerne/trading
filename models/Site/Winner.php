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
			$sql = 'INSERT INTO winners (lot_id, user_id, notify) VALUES (:lot_id, :user_id, :notify)';

			$query = $db->prepare($sql);

			$query->bindParam(':lot_id', $data['lot_id']);
			$query->bindParam(':user_id', $data['user_id']);
			$query->bindParam(':notify', $data['notify']);

			return $query->execute();
		} else {
			return true;
		}
	}

	public function show(string $id)
	{
        $db = \DB::get_connection();

        $sql = 'SELECT notify FROM winners WHERE user_id = :id';

        $query = $db->prepare($sql);
        $query->bindParam(':id', $id);

        if ($query->execute()) {
            $winner = [];

            $i = 0;
            while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $winner[$i]['notify'] = $row['notify'];

                $i++;
            }
            return $winner;
        } else {
            return false;
        }	
	}

	public function change_notify(string $id, string $notify)
	{
        $db = \DB::get_connection();

        $sql = 'UPDATE winners SET notify = :notify WHERE user_id = :id';

        $query = $db->prepare($sql);

        $query->bindParam(':notify', $notify);
        $query->bindParam(':id', $id);

        return $query->execute();	
	}
}