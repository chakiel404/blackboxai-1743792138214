<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_test extends CI_Controller {
    public function index() {
        // Test Create User
        $user_data = [
            'email' => 'testuser@example.com',
            'full_name' => 'Test User',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'admin',
            'status' => 'active'
        ];
        $this->User_model->add_user($user_data);
        
        // Test Read User
        $users = $this->User_model->get_all_users();
        print_r($users);
        
        // Test Update User
        $user_id = $users[0]->user_id; // Assuming there's at least one user
        $this->User_model->update_user($user_id, ['full_name' => 'Updated User']);
        
        // Test Delete User
        $this->User_model->delete_user($user_id);
    }
}
?>