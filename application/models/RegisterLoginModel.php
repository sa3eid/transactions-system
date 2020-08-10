<?php

// model for handling both registeration and login
class RegisterLoginModel extends CI_Model
{

    public $UserName;
    public $Password;
    public $Email;
    public $BirthDate;
    public $CountryId;
    public $Bio;
    public $Photo;

    // saving user data into users table of income-outcome db
    public function insert_entry($username, $hashed_pass, $email, $birth_date, $country_id, $bio)
    {
        $this->UserName  = $username;
        $this->Password  = $hashed_pass;
        $this->Email     = $email;
        $this->BirthDate = $birth_date;
        $this->CountryId = $country_id;
        $this->Bio       = $bio;
        $this->Photo     = "default.png";

        $this->db->insert('users', $this);
        return $this->db->insert_id();
    }

    // verifying user login credentials
    public function logged($username, $password)
    {
        $hashedpass = $this->db->select('Password')->from('users')->where('UserName', $username)->get()->row();
        // echo $hashedpass->Password;
        //echo json_encode($hashedpass);
        $result = $this->db->where('UserName', $username)->get('users');

        if ($result->num_rows() == 1) {
            if (password_verify($password, $hashedpass->Password)) {
                return $result->row();
            }
        } else {
            return false;
        }
    }

    /**
     * retreive searched data from database using seach term
     */

    public function search_country($term = "")
    {

        $cdata = array();
        $query = $this->db->from('countries')->select('Id, Name')->like('Name', $term)->get();
        if ($query->num_rows() > 0) {

            $searched = $query->result();

            foreach ($searched as $s) {
                $searchedData['id']   = $s->Id;
                $searchedData['text'] = $s->Name;
                $cdata[]              = $searchedData;
            }
            return $cdata;
        } else {
            return false;
        }
    }

    // update image name in users table after uploading
    public function image_upload($id, $fullname)
    {
        $sql = "UPDATE users SET Photo= '$fullname' WHERE Id= '$id' ";
        $this->db->query($sql);
    }

    //get image name from users table
    public function get_img($id)
    {
        // $sql = "SELECT Photo from users WHERE Id = '$id';";
        // $result = $this->db->query($sql);

        // return the result of query as object of the first row found
        $query = $this->db->from('users')->select('Photo')->where('Id', $id)->get()->row();

        //   return $query->result_array();

        //   if ($query->num_rows() > 0) {
        //    foreach ($query->result_array() as $row) {
        //     return $row['Photo'];
        //    }
        //   }
        return $query;
    }

    //select some attributes from users table
    public function get_records($id)
    {
        $query = $this->db->from('users')->select('Email, BirthDate, CountryId')->where('Id', $id)->get()->row();
        return $query;
    }

    // edit user's record
    public function edit_record($id, $username, $email, $hashed_pass = "", $birth_date, $country_id)
    {
        //check if user's new email is unique or not
        $query = $this->db->select('Email')->from('users')->where('Email', $email)->where('UserName !=', $username)->get()->result();
        // echo $this->db->last_query();

        // if email is unique
        if ($query == []) {
            if ($hashed_pass == "") {
                $data = array(
                    'Email'     => $email,
                    'BirthDate' => $birth_date,
                    'CountryId' => $country_id,
                );
            } else {
                $data = array(
                    'Email'     => $email,
                    'Password'  => $hashed_pass,
                    'BirthDate' => $birth_date,
                    'CountryId' => $country_id,
                );
            }

            //updating country_id for user's session, after editing user's data
            $this->session->country_id = $country_id;

            $this->db->where('id', $id)->update('users', $data);
        } else {
            return "That Email already exists";
        }
    }

    // get country name based on country id from countries table
    public function get_country()
    {
        $query = $this->db->from('countries')->select('Name')->get()->result();
        return $query;
    }

    //save category data into categories table
    public function insert_category($Name, $Type, $user_id)
    {
        $this->db->insert('categories', array("Name" => $Name, "Type" => $Type, "UserId" => $user_id));
    }

    // get category name and type from categories table
    public function get_category($id)
    {
        $query = $this->db->from('categories')->select('Id,Name,Type')->where('UserId', $id)->get();
        return $query->result();
    }

    // update category record based on category name, type and it's id
    public function update_category($id, $categ_name, $categ_type)
    {
        $data = array(
            'Name' => $categ_name,
            'Type' => $categ_type,
        );

        //update categories table
        $this->db->where('Id', $id)->update('categories', $data);
    }
}
