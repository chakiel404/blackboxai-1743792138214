<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Schedule_model');
        
        // Check if user is admin
        if (!$this->session->userdata('is_admin')) {
            redirect('login'); // Redirect to login if not admin
        }
    }

    public function index() {
        // Load view for listing schedules
        $data['schedules'] = $this->Schedule_model->get_all_schedules();
        $this->load->view('admin/schedules', $data);
    }

    public function add() {
        // Logic for adding a new schedule
        $data = [
            'class_id' => $this->input->post('class_id'),
            'subject_id' => $this->input->post('subject_id'),
            'teacher_id' => $this->input->post('teacher_id'),
            'day' => $this->input->post('day'),
            'time' => $this->input->post('time')
        ];

        if ($this->Schedule_model->add_schedule($data)) {
            $this->session->set_flashdata('success', 'Schedule added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add schedule.');
        }
        redirect('admin/schedules');
    }

    public function edit($id) {
        // Logic for editing a schedule
        $data = [
            'class_id' => $this->input->post('class_id'),
            'subject_id' => $this->input->post('subject_id'),
            'teacher_id' => $this->input->post('teacher_id'),
            'day' => $this->input->post('day'),
            'time' => $this->input->post('time')
        ];

        if ($this->Schedule_model->update_schedule($id, $data)) {
            $this->session->set_flashdata('success', 'Schedule updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update schedule.');
        }
        redirect('admin/schedules');
    }

    public function delete($id) {
        // Logic for deleting a schedule
        $this->Schedule_model->delete_schedule($id);
        $this->session->set_flashdata('success', 'Schedule deleted successfully.');
        redirect('admin/schedules'); // Redirect back to the schedule list
    }
}
?>