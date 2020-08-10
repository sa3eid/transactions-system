<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
class RegisterLogin extends CI_Controller
{
    // validating registeration form fields
    public function index()
    {
        $this->load->view('register_login');
    }

    public function signup()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.UserName]');
        $this->form_validation->set_rules('pass', 'Password', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[pass]', 'match');
        $this->form_validation->set_rules('mail', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('bdate', 'BirthDate', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('bio', 'Bio', 'required');
        if ($this->form_validation->run() == true) {
            $username = $this->input->post('username');
            //hashing password using bcrypt algorithm
            $pass        = $this->input->post('pass');
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            $email      = $this->input->post('mail');
            $birth_date = $this->input->post('bdate');
            $country_id = $this->input->post('country');
            $bio        = $this->input->post('bio');

            $id        = $this->RegisterLoginModel->insert_entry($username, $hashed_pass, $email, $birth_date, $country_id, $bio);
            $user_data = array(
                'user_id'    => $id,
                'username'   => $username,
                'email'      => $email,
                'birth_date' => $birth_date,
                'bio'        => $bio,
                'country_id' => $country_id,
                'photo'      => "default.png",
                'logged_in'  => true,
            );

            $this->session->set_userdata($user_data);
            $this->session->set_flashdata("register_success", "you have registered successfully.. now login");
            redirect('registerlogin');
        } else {
            $this->load->view('register_login');
        }
    }

    public function login()
    {
        $this->form_validation->set_rules('user', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]|max_length[20]');

        if ($this->form_validation->run() == true) {
            $username = $this->input->post('user');
            $pass     = $this->input->post('password');
            $lang = $this->input->post('lang-selection');

            $user = $this->RegisterLoginModel->logged($username, $pass, $lang);
            //set session data
            if ($user) {
                $user_data = array(
                    'user_id'    => $user->Id,
                    'username'   => $user->UserName,
                    'email'      => $user->Email,
                    'birth_date' => $user->BirthDate,
                    'country_id' => $user->CountryId,
                    'bio'        => $user->Bio,
                    'photo'      => $user->Photo,
                    'logged_in'  => true,
                    'user_lang' => $lang,
                );

                // echo json_encode($user_data);
                $this->session->set_userdata($user_data);

                redirect('dashboard/#income');
            } else {
                // $this->session->set_flashdata('login_failed', 'Login is invalid');
                redirect('registerlogin');
            }
        } else {
            $this->session->set_flashdata('login_failed', 'Login is invalid');
            $this->load->view('register_login');
        }
    }

    public function user_country()
    {

        $term     = $this->input->post('searchTerm');
        $searched = $this->RegisterLoginModel->search_country($term);

        echo json_encode($searched);
    }
}
