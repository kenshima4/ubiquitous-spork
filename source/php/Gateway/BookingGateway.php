<?php
namespace Src\Gateways;

// JSON to fit remote API
// {
//     "Unit Type ID": <int>,
//     "Arrival": "yyyy-mm-dd",
//     "Departure": "yyyy-mm-dd",
//     "Guests": [
//         {
//             "Age Group": "Adult"
//         },
//         {
//             "Age Group": "Child"
//         }
//     ]
// }
// Unit Type IDs [-2147483637,-2147483456] for testing

class BookingGateway {

    private $url;
    private $unitTypeId;

    public function __construct()
    {
        $this->url = getenv("URL");
        
    }

    public function queryAll()
    {
        $statement = "
            SELECT 
                id, firstname, lastname, firstparent_id, secondparent_id
            FROM
                person;
        ";

        try {
            // $statement = $this->db->query($statement);
            // $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $result = "200 OK Testing";
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    // public function find($id)
    // {
    //     $statement = "
    //         SELECT 
    //             id, firstname, lastname, firstparent_id, secondparent_id
    //         FROM
    //             person
    //         WHERE id = ?;
    //     ";

    //     try {
    //         $statement = $this->db->prepare($statement);
    //         $statement->execute(array($id));
    //         $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    //         return $result;
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }    
    // }

    public function insert(Array $input)
    {
        // $statement = "
        //     INSERT INTO person 
        //         (firstname, lastname, firstparent_id, secondparent_id)
        //     VALUES
        //         (:firstname, :lastname, :firstparent_id, :secondparent_id);
        // ";

        // try {
        //     $statement = $this->db->prepare($statement);
        //     $statement->execute(array(
        //         'firstname' => $input['firstname'],
        //         'lastname'  => $input['lastname'],
        //         'firstparent_id' => $input['firstparent_id'] ?? null,
        //         'secondparent_id' => $input['secondparent_id'] ?? null,
        //     ));
        //     return $statement->rowCount();
        // } catch (\PDOException $e) {
        //     exit($e->getMessage());
        // }    
    }

    // public function update($id, Array $input)
    // {
    //     $statement = "
    //         UPDATE person
    //         SET 
    //             firstname = :firstname,
    //             lastname  = :lastname,
    //             firstparent_id = :firstparent_id,
    //             secondparent_id = :secondparent_id
    //         WHERE id = :id;
    //     ";

    //     try {
    //         $statement = $this->db->prepare($statement);
    //         $statement->execute(array(
    //             'id' => (int) $id,
    //             'firstname' => $input['firstname'],
    //             'lastname'  => $input['lastname'],
    //             'firstparent_id' => $input['firstparent_id'] ?? null,
    //             'secondparent_id' => $input['secondparent_id'] ?? null,
    //         ));
    //         return $statement->rowCount();
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }    
    // }

    // public function delete($id)
    // {
    //     $statement = "
    //         DELETE FROM person
    //         WHERE id = :id;
    //     ";

    //     try {
    //         $statement = $this->db->prepare($statement);
    //         $statement->execute(array('id' => $id));
    //         return $statement->rowCount();
    //     } catch (\PDOException $e) {
    //         exit($e->getMessage());
    //     }    
    // }
}