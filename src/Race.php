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
    public function validateDataRace($data){
        $errors = [];
        $id = $data['race_id'];
        $race = $this->db->readById($id,'race');
        if ($data['race_start'] < $race['race_start']){
            $errors[] = 'Race start date invalid';
        } 
        return $errors;
    }
    public function validateImageRace($files){
        $errors = [];
        foreach ($files as $file) {
            // $errors[] = $file['name'];
            if ($file['size'] > 1000000) {
                $errors[] = 'File size must be less than 1MB' . ' ' . $file['name'] . ' ' . $file['size'];
                
            }
            $file_type = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
                $errors[] = 'File must be a jpg, jpeg, or png';
                break;
            }
        }
        return $errors;
    }
    public function oldImageProcess($data){
        $index = 1;
        $old_image = [];
        
        unset($data['race_name'],$data['race_start'],$data['entry_prefix'],$data['race_id']);
        foreach($data as $key => $value){
            if ($key == 'image_' . $index){
                $old_image['image_' . $index] = [
                    'image_' . $index => $data['image_' . $index],
                    'description_' . $index => $data['description_' . $index],
                    'old' => $data['old_' . $index],
                    'new' => $index
                ];
                unset($data['image_' . $index], $data['description_' . $index], $data['old_' . $index]);
                $index++;
            }
        }
        foreach($old_image as $key => $image){
            $old_name = "../media/race_image/image_" . $image['old'];
            $old_url = $image[$key];
            $new_name = "../media/race_image/image_" . $image['new'];
            $new_url = str_replace($old_name, $new_name, $old_url);
            
            rename($old_url,$new_url);
            $old_image[$key][$key] = $new_url;
        }
        return [$old_image,$data];
    }
    public function saveOldImage($data, $race_id){
        $index = 1;
        foreach($data as $prefix => $image){
            $this->db->create([
                'race_id' => $race_id,
                'url' => $image[$prefix],
                'description' => $image['description_' . $index]
            ],'gallery');
            $index++;
        }
    }
    public function saveNewImage($data, $files, $race_id){
        foreach($data as $key => $value){
            $index = str_replace('description_','',$key);    
            try{
                $name = $files['image_' . $index]['name'];
                $description = $data['description_' . $index];
                $path = '../media/race_image/' . 'image_' . $index . 'race_' . $race_id . '_' . $name;
                move_uploaded_file($files['image_' . $index]['tmp_name'], $path);
                $this->db->create([
                    'url' => $path,
                    'description' => $description,
                    'race_id' => $race_id,
                ], 'gallery');
            } catch(Exception $e){
                return $e;
            }
        }
        $images = $this->db->readByColumn('race_id', $race_id, 'gallery');
        $name_images = [];
        foreach($images as $image){
            $name_images[] = $image['url'];
        }
        // Delete old images
        $old_images = glob('../media/race_image/' . 'image_*' . $race_id . '*');
        foreach($old_images as $old_image){
            if(!in_array($old_image, $name_images)){
                unlink($old_image);
            }
        }
        return;
    }
    public function updateRace($data, $files){
        $errors = array_merge($this->validateDataRace($data), $this->validateImageRace($files));
        if(empty($errors)){
            $race_id = $data['race_id'];
            $race_data = [
                'id' => $race_id,
                'race_name' => $data['race_name'],
                'race_start' => $data['race_start'],
                'entry_prefix' => $data['entry_prefix']

            ];
            $this->db->update($race_data,'race');

            $new_data = $this->oldImageProcess($data);
            $this->db->deleteByField('race_id', $race_id, 'gallery');
            $this->saveOldImage($new_data[0],$race_id);
            $errors = $this->saveNewImage($new_data[1],$files, $race_id);
            if(!empty($errors)){
                return $errors;
            }
            return;
        } else {
            return $errors;
        }        
    }
    public function deleteRace($id){
        $images = $this->db->readByColumn('race_id', $id, 'gallery');
        foreach($images as $image){
            unlink($image['url']);
        }
        $this->db->delete($id, 'race');
    }
    public function registerRace($race_id, $entry_prefix , $user_id, $hotel_name=null){
        // Check if user already registered
        $register = $this->db->getRegisteredUsers($race_id, $user_id);
        if(!empty($register)){
            return 'You have already registered for this race';
        }
        $index = $this->db->counter([
            'race_id' => $race_id,
        ], 'register_form') + 1;
        if($hotel_name){
            $this->db->create([
                'race_id' => $race_id,
                'user_id' => $user_id,
                'hotel_name' => $hotel_name
            ], 'register_form');
        } else {
            $this->db->create([
                'race_id' => $race_id,
                'user_id' => $user_id,
            ], 'register_form');
        }
        // return $register[0]['index'];

        $this->db->query('UPDATE register_form SET entry_number = "' . $entry_prefix. '_' . $index . '" WHERE race_id = ' . $race_id . ' AND user_id = ' . $user_id);
        return;
    }
        
}


?>