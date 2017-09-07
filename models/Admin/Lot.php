<?php 

namespace Admin;

use \models\Model as Model;

class Lot extends Model
{
    public function get_all()
    {
        $db = \DB::get_connection();

        $sql = "SELECT l.id, l.name, l.characteristics, l.price, l.price_type, l.count, l.count_type, l.conditions_payment, l.conditions_shipment, l.terms_shipment, l.step_bet, l.start, l.stop, l.status, GROUP_CONCAT(DISTINCT g.id, g.name SEPARATOR ', ') AS groups FROM lots l JOIN lots_groups l_g ON l.id = l_g.lot_id JOIN groups g ON l_g.group_id = g.id GROUP BY l.id ORDER BY l.id DESC";

        $query = $db->prepare($sql);

        $lots = [];
        if ($query->execute()) {      
            $i = 0; 
            while ($row = $query->fetch()) {
                $lots[$i]['id'] = $row['id'];
                $lots[$i]['name'] = $row['name'];
                $lots[$i]['characteristics'] = $row['characteristics'];
                $lots[$i]['price'] = $row['price'];
                $lots[$i]['price_type'] = $row['price_type'];
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

    public function create(array $data)
    {
        $data = $this->validate($data, [
            'name' => 'empty|length',
            'characteristics' => 'empty',
            'price' => 'empty|length_integer',
            'price_type' => 'empty|length',
            'groups' => 'empty',
            'step_bet' => 'length_integer',
            'count' => 'empty',
            'count_type' => 'empty|length',
            'conditions_payment' => 'empty|length',
            'conditions_shipment' => 'empty|length',
            'terms_shipment' => 'empty|length',
            'start' => 'empty',
            'stop' => 'empty',
            'status' => 'empty'
        ]);
        
        $db = \DB::get_connection();

        $sql = 'INSERT INTO lots (name, characteristics, price, price_type, step_bet, count, count_type, conditions_payment, conditions_shipment, terms_shipment, start, stop, status) VALUES (:name, :characteristics, :price, :price_type, :step_bet, :count, :count_type, :conditions_payment, :conditions_shipment, :terms_shipment, :start, :stop, :status)';

        $query = $db->prepare($sql);

        $step_bet = $this->get_step_bet($data['step_bet']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':characteristics', $data['characteristics']);
        $query->bindParam(':price', $data['price']);
        $query->bindParam(':price_type', $data['price_type']);
        $query->bindParam(':count', $data['count']);
        $query->bindParam(':count_type', $data['count_type']);
        $query->bindParam(':conditions_payment', $data['conditions_payment']);
        $query->bindParam(':conditions_shipment', $data['conditions_shipment']);
        $query->bindParam(':terms_shipment', $data['terms_shipment']);
        $query->bindParam(':step_bet', $step_bet);
        $query->bindParam(':start', $data['start']);
        $query->bindParam(':stop', $data['stop']);
        $query->bindParam(':status', $data['status']);

        if ($query->execute()) {
            $sql = 'INSERT INTO lots_groups (lot_id, group_id) VALUES (:lot_id, :group_id)';

            $query = $db->prepare($sql);
            $lot_id = $db->lastInsertId();
            $query->bindParam(':lot_id', $lot_id);

            $result = 0;
            foreach ($data['groups'] as &$group_id) {
                $query->bindParam(':group_id', $group_id);
                if ($query->execute()) {
                    $result += 1;
                } else {
                    $result -= 1;
                }
            }

            if ($result) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function show(string $id)
    {
        $db = \DB::get_connection();

        $sql = "SELECT l.id, l.name, l.characteristics, l.price, l.price_type, l.step_bet, l.count, l.count_type, l.conditions_payment, l.conditions_shipment, l.terms_shipment, l.start, l.stop, l.status, GROUP_CONCAT(DISTINCT g.id SEPARATOR ', ') AS groups FROM lots l JOIN lots_groups l_g ON l.id = l_g.lot_id JOIN groups g ON l_g.group_id = g.id WHERE l.id = :id GROUP BY l.id";
        
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            return $query->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }

    }

    public function update(array $data): bool
    {
        $data = $this->validate($data, [
            'name' => 'empty|length',
            'characteristics' => 'empty',
            'price' => 'empty|length_integer',
            'price_type' => 'empty|length',
            'groups' => 'empty',
            'step_bet' => 'length_integer',
            'count' => 'empty',
            'count_type' => 'empty|length',
            'conditions_payment' => 'empty|length',
            'conditions_shipment' => 'empty|length',
            'terms_shipment' => 'empty|length',
            'start' => 'empty',
            'stop' => 'empty',
            'status' => 'empty'
        ]);
        
        $db = \DB::get_connection();
        
        $sql = 'UPDATE lots SET name = :name, price = :price, price_type = :price_type, count = :count, count_type = :count_type, characteristics = :characteristics, conditions_payment = :conditions_payment, conditions_shipment = :conditions_shipment, terms_shipment = :terms_shipment, step_bet = :step_bet, start = :start, stop = :stop, status = :status WHERE id = :lot_id';

        $query = $db->prepare($sql);

        $step_bet = $this->get_step_bet($data['step_bet']);
        $query->bindParam(':lot_id', $data['lot_id']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':count', $data['count']);
        $query->bindParam(':count_type', $data['count_type']);
        $query->bindParam(':price', $data['price']);
        $query->bindParam(':price_type', $data['price_type']);
        $query->bindParam(':characteristics', $data['characteristics']);
        $query->bindParam(':conditions_payment', $data['conditions_payment']);
        $query->bindParam(':conditions_shipment', $data['conditions_shipment']);
        $query->bindParam(':terms_shipment', $data['terms_shipment']);
        $query->bindParam(':step_bet', $step_bet);
        $query->bindParam(':start', $data['start']);
        $query->bindParam(':stop', $data['stop']);
        $query->bindParam(':status', $data['status']);

        if ($query->execute()) {
            $lot_id = $data['lot_id'];

            $sql = 'DELETE FROM lots_groups WHERE lot_id = :lot_id';

            $query = $db->prepare($sql);
            $query->bindParam(':lot_id', $lot_id);

            if ($query->execute()) {
                $sql = 'INSERT INTO lots_groups (lot_id, group_id) VALUES (:lot_id, :group_id)';

                $query = $db->prepare($sql);
                $query->bindParam(':lot_id', $lot_id);

                $result = 0;
                foreach ($data['groups'] as &$group_id) {
                    $query->bindParam(':group_id', $group_id);

                    if ($query->execute()) {
                        $result += 1;
                    } else {
                        $result -= 1;
                    }
                }

                if ($result) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete(string $id): bool
    {
        $db = \DB::get_connection();

        $sql = 'DELETE FROM lots WHERE id = :id';
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            $sql = 'DELETE FROM lots_groups WHERE lot_id = :lot_id';

            $query = $db->prepare($sql);
            $query->bindParam(':lot_id', $id);

            if ($query->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function get_step_bet(string $value_field)
    {
        if ($value_field) {
            $step_bet = $value_field;
        } else {
            $step_bet = 100;
        }

        return $step_bet;
    }
}