<?php

namespace Site;

use \models\Model as Model;

class Bet extends Model
{
	public function get_all()
	{
		$db = \DB::get_connection();

		$sql = 'SELECT l_u_b.bet, l_u_b.user_id, l_u_b.create_date, u.name, u.email FROM lots_users_bets l_u_b JOIN users u ON l_u_b.user_id = u.id ORDER BY l_u_b.id DESC';

		$query = $db->prepare($sql);

		if (!$query->execute()) {
			return false;
		}

		$bets = [];

		$i = 0;
		while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
			$bets[$i]['user_id'] = $row['user_id'];
			$bets[$i]['bet'] = $row['bet'];
			$bets[$i]['create_date'] = $row['create_date'];
			$bets[$i]['user_name'] = $row['name'];
			$bets[$i]['user_email'] = $row['email'];

			$i++;
		}

		return $bets;
	}

	public function get_all_by_each_lot(string $id)
	{
		$db = \DB::get_connection();

		$sql = 'SELECT l_u_b.bet, l_u_b.user_id, l_u_b.create_date, u.name, u.login, u.email FROM lots_users_bets l_u_b JOIN users u ON l_u_b.user_id = u.id WHERE l_u_b.lot_id = :id ORDER BY l_u_b.id DESC';

		$query = $db->prepare($sql);
		$query->bindParam(':id', $id);

		if (!$query->execute()) {
			return false;
		}

		$bets = [];

		$i = 0;
		while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
			$bets[$i]['user_id'] = $row['user_id'];
			$bets[$i]['user_login'] = $row['login'];
			$bets[$i]['user_name'] = $row['name'];
			$bets[$i]['user_email'] = $row['email'];
			$bets[$i]['bet'] = $row['bet'];
			$bets[$i]['create_date'] = $row['create_date'];

			$i++;
		}

		return $bets;
	}

	public function create(array $data): bool
    {
        $data = $this->validate($data, [
            'bet' => 'empty|length_integer',
        ]);

        $db = \DB::get_connection();

        $sql = 'INSERT INTO lots_users_bets (lot_id, user_id, bet) VALUES (:lot_id, :user_id, :bet)';

        $query = $db->prepare($sql);

        $query->bindParam(':lot_id', $data['lot_id']);
        $query->bindParam(':user_id', $data['user_id']);
        $query->bindParam(':bet', $data['bet']);

        return $query->execute();
    }
}