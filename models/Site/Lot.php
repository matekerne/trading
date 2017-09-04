<?php 

namespace Site;

use \models\Model as Model;

class Lot extends Model
{
    public function get_all()
    {
        $db = \DB::get_connection();

        $sql = 'SELECT id, name, price, characteristics, count, conditions_payment, conditions_shipment, terms_shipment, step_bet, start, stop, status FROM lots WHERE status = 1 ORDER BY id DESC';

        $query = $db->prepare($sql);

        $lots = [];
        if ($query->execute()) {      
            $i = 0; 
            while ($row = $query->fetch()) {
                $lots[$i]['id'] = $row['id'];
                $lots[$i]['name'] = $row['name'];
                $lots[$i]['price'] = $row['price'];
                $lots[$i]['characteristics'] = $row['characteristics'];
                $lots[$i]['count'] = $row['count'];
                $lots[$i]['conditions_payment'] = $row['conditions_payment'];
                $lots[$i]['conditions_shipment'] = $row['conditions_shipment'];
                $lots[$i]['terms_shipment'] = $row['terms_shipment'];
                $lots[$i]['step_bet'] = $row['step_bet'];
                $lots[$i]['start'] = $row['start'];
                $lots[$i]['stop'] = $row['stop'];
                $lots[$i]['status'] = $row['status'];
                
                $i++;
            }

            return $lots;
        } else {
            return false;
        }
    }

    public function show(string $id)
    {
        $db = \DB::get_connection();

        $sql = "SELECT l.id, l.name, l.characteristics, l.price, l.count, l.count_type, l.conditions_payment, l.conditions_shipment, l.terms_shipment, l.step_bet, l.start, l.stop, l.status, GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS groups FROM lots l LEFT JOIN lots_groups l_g ON l.id = l_g.lot_id LEFT JOIN groups g ON l_g.group_id = g.id WHERE l.id = :id GROUP BY l.id";

        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            $lots = [];

            $i = 0;
            while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $lots[$i]['id'] = $row['id'];
                $lots[$i]['name'] = $row['name'];
                $lots[$i]['characteristics'] = $row['characteristics'];
                $lots[$i]['price'] = $row['price'];
                $lots[$i]['groups'] = $row['groups'];
                $lots[$i]['count'] = $row['count'];
                $lots[$i]['count_type'] = $row['count_type'];
                $lots[$i]['conditions_payment'] = $row['conditions_payment'];
                $lots[$i]['conditions_shipment'] = $row['conditions_shipment'];
                $lots[$i]['terms_shipment'] = $row['terms_shipment'];
                $lots[$i]['step_bet'] = $row['step_bet'];
                $lots[$i]['start'] = $row['start'];
                $lots[$i]['stop'] = $row['stop'];
                $lots[$i]['status'] = $row['status'];

                $i++;
            }

            return $lots;
        } else {
            return false;
        }
    }

    public function change_status(int $status, string $lot_id)
    {
        $db = \DB::get_connection();

        $sql = 'UPDATE lots SET status = :status WHERE id = :lot_id';

        $query = $db->prepare($sql);

        $query->bindParam(':status', $status);
        $query->bindParam(':lot_id', $lot_id);

        return $query->execute();
    }
}