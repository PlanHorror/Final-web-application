<?php
spl_autoload_register(function ($class) {
    require_once __DIR__ . '/' . $class . '.php';
});


class Race {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getRaces() {
        $races = $this->db->readAll('race');
        $gallery = $this->db->readAll('gallery');
        $participants = $this->db->readAll('register_form');
        // Compare today's date with race_start date
        $today = date('Y-m-d' . 'H:i:s');
        foreach ($races as $key => $race) {
            $images = [];
            $users = [];
            if ($race['race_start'] >= $today) {
                $races[$key]['status'] = 'Comming Soon';
            } else {
                $races[$key]['status'] = 'Ended';
            }
            foreach ($gallery as $image) {
                if ($image['race_id'] == $race['id']) {
                    $images[] = $image;
                }
            }
            foreach ($participants as $participant) {
                if($participant['race_id'] == $race['id']) {
                    $users[] = $participant;
                    $participant['standings'] == 1 ? $race['winner'] = $participant : null;
                }
            }
            $races[$key]['images'] = $images;
            $races[$key]['total_participants'] = count($users);
        }
        return $races;

    }
    public function getRaceById($id) {
        $race = $this->db->readById($id, 'race');
        $gallery = $this->db->readByColumn('race_id', $id, 'gallery');
        $participants = $this->db->readByColumn('race_id', $id, 'register_form');
        if ($participants) {
            foreach ($participants as $participant) {
                $participant['standings'] == 1 ? $race['winner'] = $participant : null;
            }
            $race['total_participants'] = count($participants);
        }
        $race['images'] = $gallery ? $gallery : [];
        $race['winner'] = null;  
        $race['total_participants'] = 0;
        return $race;
    }
}

?>