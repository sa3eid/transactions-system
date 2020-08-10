<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Dashboard extends CI_Controller
{

    public function get_category($cat_id)
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }
        $data = $this->db->select("*")->from("categories")->where("Id", $cat_id)->get()->row_array();
        echo $this->load->view('subviews/cat_edit', $data, true);
    }

    public function get_income($income_id)
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }
        $data = $this->db->select("*")->from("categories")->join('transactions', 'transactions.CategoryId = categories.id')
            ->where('transactions.Id', $income_id)->get()->row_array();
        echo $this->load->view('subviews/in_edit', $data, true);
    }

    public function get_outcome($outcome_id)
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }
        $data = $this->db->select("*")->from("categories")->join('transactions', 'transactions.CategoryId = categories.id')
            ->where('transactions.Id', $outcome_id)->get()->row_array();
        echo $this->load->view('subviews/out_edit', $data, true);
    }

    //load dashboard view
    public function index()
    {
        if ($this->session->username) {
            //getting user's data from database based on it's ID
            $data     = $this->RegisterLoginModel->get_records($this->session->user_id);
            $image    = $this->RegisterLoginModel->get_img($this->session->user_id);
            $country  = $this->db->select("*")->from("countries")->where("Id", $data->CountryId)->get()->result();
            $category = $this->RegisterLoginModel->get_category($this->session->user_id);

            // $this->lang->load('filename', 'language');

            if ($this->session->user_lang == 'english') {
                $this->lang->load('vars', 'english');
                $this->lang->load('msgs', 'english');
            } else {
                $this->lang->load('vars', 'arabic');
                $this->lang->load('msgs', 'arabic');
            }


            // $category_id = $this->input->post('id');
            // $income_id   = $this->input->post('iid');

            // $income = $this->IncomeOutcomeModel->get_income($this->session->user_id, $income_id);
            // passing the user's data to the dashboard view

            $dashboard_data = array(
                "data"     => $data,
                "Photo"    => $image,
                "Country"  => $country,
                "Category" => $category,
            );
            $this->load->view('dashboard', $dashboard_data);
        } else {
            redirect('registerlogin');
        }
    }

    //get image file data from ajax and upload user's profile image
    public function ajax_upload()
    {
        if (isset($_FILES['image_file']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 1048576; //total allowed size in bytes
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;

            // will give you the filename along with the extension
            // $saved_file_name = $this->upload->data('file_name');
            $filename = $_FILES["image_file"]["name"];

            // getting file extension
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

            //generate md5 hashed random filename appended with the extension (32 chars)
            $fullName = md5(uniqid(rand(), true)) . '.' . $file_ext;

            $config['file_name'] = $fullName;

            //store profile image hashed full name with extension into db
            $this->RegisterLoginModel->image_upload($this->session->user_id, $fullName);

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_file')) {
                echo $this->upload->display_errors();
            } else {
                // $data = $this->upload->data();
                // $data['file_name'] = $file_ext;
                // echo '<img src= " ' . base_url() . 'uploads/' . $fullName . '" />';

                $profile_img          = $this->RegisterLoginModel->get_img($this->session->user_id);
                $this->session->Photo = $profile_img->Photo;
                echo '<img src= " ' . base_url() . 'uploads/' . $this->session->Photo . '" />';
            }
        }
    }
    public function reset_img()
    {
        $profile = $this->input->post('Photo');
        $this->RegisterLoginModel->image_upload($this->session->user_id, $profile);
        if ($this->session->Photo != "default.png") {
            // 'C:\xampp\htdocs\income-outcome\uploads\\'
            // removing profile image file from uploads directory
            $path = 'uploads\\' . $this->session->Photo;
            unlink($path);
        }
        $this->session->Photo = "default.png";
        echo '<img src= " ' . base_url() . 'uploads/' . $this->session->Photo . '" />';
    }

    public function edit()
    {

        $this->form_validation->set_rules('mail', 'Email', 'required');
        $this->form_validation->set_rules('pass', 'Password', 'min_length[8]|max_length[20]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'matches[pass]', 'match');
        $this->form_validation->set_rules('bdate', 'BirthDate', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        if ($this->form_validation->run() == true) {

            $pass        = $this->input->post('pass');
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            $email       = $this->input->post('mail');
            $birth_date  = $this->input->post('bdate');
            $country_id  = $this->input->post('country');
            $pass        = $this->input->post('pass');
            $hashed_pass = $pass ? password_hash($pass, PASSWORD_DEFAULT) : "";

            echo $this->RegisterLoginModel->edit_record($this->session->user_id, $this->session->username, $email, $hashed_pass, $birth_date, $country_id);
            // return 'Record updated';
            $this->session->flashdata('update_success', 'user data updated successfully');
            // redirect('dashboard');
        } else {
            echo validation_errors();
        }
    }

    // category controller to process data and send it to insert_category model function
    public function category()
    {
        $name = $this->input->post('categ_name');
        $type = $this->input->post('categ_type');

        $this->RegisterLoginModel->insert_category($name, $type, $this->session->user_id);
    }

    //processing category edit data
    public function category_edit()
    {
        $categ_id   = $this->input->post('edit_cid');
        $categ_name = $this->input->post('edit_categ_name');
        $categ_type = $this->input->post('edit_categ_type');

        $this->RegisterLoginModel->update_category($categ_id, $categ_name, $categ_type);
    }

    //handling datatable
    public function data_table()
    {

        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
        }
        $filters = array(
            "name" => $this->input->post('name'),
            "type" => $this->input->post('type'),
        );

        $columns = array(
            0 => 'name',
            1 => 'type',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData     = $this->TableModel->allposts_count();
        $totalFiltered = $totalData;

        if (!empty($this->input->post('search')['value'])) {
            $search        = $this->input->post('search')['value'];
            $posts         = $this->TableModel->posts_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->TableModel->posts_search_count($search);
        } else {
            if (!empty($filters)) {
                $posts = $this->TableModel->allposts($limit, $start, $order, $dir, $filters, $this->session->user_id);
            }
        }

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['Name'] = $post->Name;
                $nestedData['Type'] = $post->Type;
                //edit link
                $nestedData['action'] = '<button type="button" class="btn btn-warning edit" id="' . $post->Id . '">' . $this->lang->line("Click here to edit data") . ' </button>&nbsp<button type="button" class="btn btn-danger delcat" id="' . $post->Id . '">' . $this->lang->line("Click here to delete data") . '</button>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        echo json_encode($json_data);
    }
    // income controller to process data and send it to insert_income model function

    public function income()
    {
        // echo "<pre>";
        // print_r($this->input->post());

        $category       = $this->input->post('icategory');
        $income_date    = $this->input->post('income_date');
        $income_comment = $this->input->post('comment_area');
        foreach ($category as $cat => $value) {
            if ($value) {
                // $cat refers to key defined by categoryname & $value refers to its amount
                $this->IncomeOutcomeModel->insert_income($cat, $value, $this->session->user_id, $income_date, $income_comment);
            }
        }
    }

    // processing data and send it to income model
    public function income_table()
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
        }

        //filters used as criteria in searching income datatable

        $filters = array(
            "categories"  => $this->input->post('icat'),
            "amount_from" => $this->input->post('iamount_f'),
            "amount_to"   => $this->input->post('iamount_t'),
            "date_from"   => $this->input->post('idate_f'),
            "date_to"     => $this->input->post('idate_t'),
        );

        $columns = array(
            0 => 'Name',
            1 => 'Amount',
            2 => 'Date',
            3 => 'Comment',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData     = $this->IncomeTableModel->allposts_count($this->session->user_id);
        $totalFiltered = $totalData;

        if (!empty($this->input->post('search')['value'])) {
            $search        = $this->input->post('search')['value'];
            $posts         = $this->IncomeTableModel->posts_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->IncomeTableModel->posts_search_count($search);
        } else {
            if (!empty($filters)) {
                $posts = $this->IncomeTableModel->allposts($limit, $start, $order, $dir, $filters, $this->session->user_id);
            }
        }

        // $posts = $this->IncomeTableModel->allposts($limit, $start, $order, $dir, $this->session->user_id);

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['Income']  = $post->Name;
                $nestedData['Amount']  = number_format($post->Amount, 2);
                $nestedData['Date']    = $post->Date;
                $nestedData['Comment'] = $post->Comment;
                $nestedData['action']  = '<button type="button" class="btn btn-warning iedit" id="' . $post->Id . '">' . $this->lang->line("Click here to edit data") . '</button>&nbsp<button type="button" class="btn btn-danger delin" id="' . $post->Id . '">' . $this->lang->line("Click here to delete data") . '</button>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        echo json_encode($json_data);
    }
    // outcome controller to process data and send it to insert_outcome model function

    public function outcome()
    {
        $category        = $this->input->post('ocategory');
        $outcome_date    = $this->input->post('outcome_date');
        $outcome_comment = $this->input->post('o_comment');

        foreach ($category as $cat => $value) {
            if ($value) {
                $this->IncomeOutcomeModel->insert_outcome($cat, $value, $this->session->user_id, $outcome_date, $outcome_comment);
            }
        }
    }

    public function outcome_table()
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
        }
        $filters = array(
            "categories"  => $this->input->post('ocat'),
            "amount_from" => $this->input->post('oamount_f'),
            "amount_to"   => $this->input->post('oamount_t'),
            "date_from"   => $this->input->post('odate_f'),
            "date_to"     => $this->input->post('odate_t'),
        );

        $columns = array(
            0 => 'Name',
            1 => 'Amount',
            2 => 'Date',
            3 => 'Comment',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir   = $this->input->post('order')[0]['dir'];

        $totalData     = $this->OutcomeTableModel->allposts_count($this->session->user_id);
        $totalFiltered = $totalData;

        if (!empty($this->input->post('search')['value'])) {
            $search        = $this->input->post('search')['value'];
            $posts         = $this->OutcomeTableModel->posts_search($limit, $start, $search, $order, $dir);
            $totalFiltered = $this->OutcomeTableModel->posts_search_count($search);
        } else {
            if (!empty($filters)) {
                $posts = $this->OutcomeTableModel->allposts($limit, $start, $order, $dir, $filters, $this->session->user_id);
            }
        }

        // $posts = $this->OutcomeTableModel->allposts($limit, $start, $order, $dir, $this->session->user_id);

        $data = array();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $nestedData['Outcome'] = $post->Name;
                $nestedData['Amount']  = number_format($post->Amount, 2);
                $nestedData['Date']    = $post->Date;
                $nestedData['Comment'] = $post->Comment;
                $nestedData['action']  = '<button type="button" class="btn btn-warning oedit" id="' . $post->Id . '">' . $this->lang->line("Click here to edit data") . '</button>&nbsp<button type="button" class="btn btn-danger delout" id="' . $post->Id . '">' . $this->lang->line("Click here to delete data") . '</button>';

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        echo json_encode($json_data);
    }

    //processing income data for edit
    public function income_edit()
    {
        $income_cat_id = $this->input->post('income_category');
        $income_amount  = $this->input->post('income_amount');
        $trans_id       = $this->input->post('income_id');
        $income_date    = $this->input->post('income_date');
        $income_comment = $this->input->post('comment_area');

        $this->IncomeOutcomeModel->update_income($income_cat_id, $trans_id, $income_amount, $income_date, $income_comment);
    }

    //processing outcome data for edit
    public function outcome_edit()
    {
        $outcome_cat_id = $this->input->post('outcome_category');
        $outcome_amount  = $this->input->post('outcome_amount');
        $trans_id        = $this->input->post('outcome_id');
        $outcome_date    = $this->input->post('outcome_date');
        $outcome_comment = $this->input->post('o_comment');

        $this->IncomeOutcomeModel->update_outcome($outcome_cat_id, $trans_id, $outcome_amount, $outcome_date, $outcome_comment);
    }

    //search by income category
    public function income_selection()
    {
        $term     = $this->input->post('searchTerm');
        $searched = $this->IncomeOutcomeModel->select_income_category($term);

        echo json_encode($searched);
    }

    //search by outcome category
    public function outcome_selection()
    {
        $term     = $this->input->post('searchTerm');
        $searched = $this->IncomeOutcomeModel->select_outcome_category($term);

        echo json_encode($searched);
    }

    //delete category from category table if not used by transactions
    public function delete_category()
    {
        $del_id = $this->input->post('del_id');

        echo $this->IncomeOutcomeModel->delete_cat($del_id);
    }

    //delete income/outcome transaction
    public function delete_transaction()
    {
        $del_id = $this->input->post('del_tid');

        $this->IncomeOutcomeModel->delete_trans($del_id);
    }

    //get total for each category in datatable
    public function income_subtotal()
    {
        //load language for income_subtotal controller
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
        }

        $result = $this->IncomeOutcomeModel->isubtotal($this->input->get(NULL, TRUE), $this->session->user_id);
        foreach ($result as $r) {
            if ($r->Type == "income" || $r->Type == "both") {
                echo $this->lang->line('Total amount for') . " " . $r->Name . " = " . number_format($r->asum) . "<br>";
            }
        }
    }

    //get total for each category in datatable
    public function outcome_subtotal()
    {
        //load language for outcome_subtotal controller

        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
        }
        $result = $this->IncomeOutcomeModel->osubtotal($this->input->get(NULL, TRUE), $this->session->user_id);

        foreach ($result as $r) {
            if ($r->Type == "outcome" || $r->Type == "both") {
                echo $this->lang->line('Total amount for') . " " . $r->Name . " = " . number_format($r->asum) . "<br>";
            }
        }
    }

    //handling outcome statistics subview with filtered data
    public function income_statistics()
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }

        $filtered_cats = [];
        $filtered_data = [];
        $filtered_dates = [];

        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "incomeoutcome";
        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
        //enable UTF-8 character encoding
        $conn->set_charset("UTF8");
        if (!$conn) {
            die("Connection error " . mysqli_connect_error());
        }

        // $sql_by_date = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum from categories inner join transactions on transactions.CategoryId = categories.Id where categories.type='income' group by transactions.Date;";

        // $sql_by_category = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum from categories inner join transactions on transactions.CategoryId = categories.Id where categories.type='income' group by transactions.CategoryId;";

        // //statitics by date
        // $result_by_date = mysqli_query($conn, $sql_by_date);

        // //statitics by category
        // $result_by_category = mysqli_query($conn, $sql_by_category);

        //get filtered results into array form
        $sql_result = $this->StatisticsModel->filterIncomeStatistics($this->input->get(NULL, TRUE), $this->session->user_id);

        $filtered_result_by_category = mysqli_query($conn, $sql_result['sql']);
        $filtered_result_by_date = mysqli_query($conn, $sql_result['isql']);

        // echo json_encode($filter_result);

        while ($row = mysqli_fetch_array($filtered_result_by_category)) {
            extract($row);
            $filtered_cats[] = "['$Name', $tsum]";
        }
        while ($row = mysqli_fetch_array($filtered_result_by_date)) {
            extract($row);
            $filtered_data[] = "['$Name',$tsum]";
            $filtered_dates[] = "['$Date']";
        }

        // while ($row = mysqli_fetch_array($result_by_category)) {
        //     extract($row);
        //     $cats[] = "['$Name', $tsum]";
        // }

        // while ($row = mysqli_fetch_array($result_by_date)) {
        //     extract($row);
        //     $data[] = "['$Name',$tsum]";
        //     $dates[] = "['$Date']";
        // }

        // echo json_encode($filtered_cats);

        // echo json_encode($cats);

        // echo join($cats, ',');
        if ($filtered_cats != [] && $filtered_dates != [] && $filtered_data != []) {
            echo $this->load->view('subviews/istatistics', array('filtered_cats' => $filtered_cats, 'filtered_dates' => $filtered_dates, 'filtered_data' => $filtered_data), true);
        }
    }

    //handling outcome statistics subview with filtered data
    public function outcome_statistics()
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }

        $filtered_cats = [];
        $filtered_data = [];
        $filtered_dates = [];

        $dbServername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "incomeoutcome";
        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
        //enable UTF-8 character encoding
        $conn->set_charset("UTF8");
        if (!$conn) {
            die("Connection error " . mysqli_connect_error());
        }

        //get filtered results into array form
        $sql_result = $this->StatisticsModel->filterOutcomeStatistics($this->input->get(NULL, TRUE), $this->session->user_id);

        $filtered_result_by_category = mysqli_query($conn, $sql_result['sql']);
        $filtered_result_by_date = mysqli_query($conn, $sql_result['isql']);

        while ($row = mysqli_fetch_array($filtered_result_by_category)) {
            extract($row);
            $filtered_cats[] = "['$Name', $tsum]";
        }
        while ($row = mysqli_fetch_array($filtered_result_by_date)) {
            extract($row);
            $filtered_data[] = "['$Name',$tsum]";
            $filtered_dates[] = "['$Date']";
        }

        if ($filtered_cats != [] && $filtered_dates != [] && $filtered_data != []) {
            echo $this->load->view('subviews/ostatistics', array('filtered_cats' => $filtered_cats, 'filtered_dates' => $filtered_dates, 'filtered_data' => $filtered_data), true);
        }
    }

    //handling upload of income xlsx file, parsing then processing its data to database
    public function excel_iupload()
    {

        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }

        $ilogs = [];
        require_once 'assets/SimpleXLSX.php';

        if (isset($_FILES['excel_ifile']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 1048576; //total allowed size in bytes

            $filename = $_FILES["excel_ifile"]["name"];
            // echo $filename;

            $path = 'uploads\\' . $filename;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel_ifile')) {
                echo $this->upload->display_errors();
            } else {
                //parse xlsx file using simplexlsx script

                // echo '<h1>Parse income data</h1><pre>';
                if ($xlsx = SimpleXLSX::parse($path)) {
                    // echo '<h2>Parsing Result</h2>';
                    // echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

                    $dim = $xlsx->dimension();
                    $cols = $dim[0];

                    $counter = 0;
                    $invalid_records = array(0);

                    $error_logs = array();

                    $invalid_counter = 0;
                    //loop through rows
                    // '<pre>' . print_r($xlsx->rows()) . '</pre>';
                    $header = $xlsx->rows()[0];
                    // '<pre>' . print_r($header) . '</pre>';

                    $xlsx_arr = $xlsx->rows();
                    //remove first row in the xlx file
                    unset($xlsx_arr[0]);

                    foreach ($xlsx_arr as $k => $r) {
                        // if ($k == 0) continue; // skip first row
                        // echo $r[0] . $r[1] . $r[2] . $r[3];
                        $counter += 1;

                        // echo '<tr>';
                        // //loop through columns
                        // echo '<td>' . (isset($r) ? json_encode($r) : '&nbsp;') . '</td>';

                        if ($r[0] == '' && $r[1] == '' && $r[2] == '' && $r[3] == '') {
                            array_push($error_logs, sprintf($this->lang->line('empty record at (%s) th record'), $k += 1));
                            array_push($invalid_records, $k -= 1);
                        }

                        //check for invalid date
                        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $r[0])) {
                            $invalid_counter += 1;
                            // echo "invalid date at " . $k . "th record" . '<br>';
                            // array_push($error_logs, "invalid date at " . $k . "th record");
                            array_push($error_logs, sprintf($this->lang->line('invalid date at (%s) th record'), $k += 1));
                            array_push($invalid_records, $k -= 1);
                        } else {
                        }
                        //check for invalid numbers
                        if (is_numeric($r[2]) && $r[2] >= 0) {
                        } else {


                            $invalid_counter += 1;
                            // echo "invalid number at " . $k . 'th record' . '<br>';
                            // array_push($error_logs, "invalid number at " . $k . "th record");
                            array_push($error_logs, sprintf($this->lang->line('invalid number at (%s) th record'), $k += 1));
                            array_push($invalid_records, $k -= 1);
                        }

                        //check for invalid categories
                        if ($r[1]) {

                            $query = $this->db->select('Name')->from('categories')->where('Name', $r[1])->where('Type', 'income')->get()->result();
                            if ($query == [] || $r[1] == '') {
                                $invalid_counter += 1;
                                // echo "invalid category at " . $k . 'th record' . '<br>';
                                // array_push($error_logs, "invalid category at " . $k . "th record");
                                array_push($error_logs, sprintf($this->lang->line('invalid category at (%s) th record'), $k += 1));

                                array_push($invalid_records, $k -= 1);

                                // echo $r[$i];
                            }
                        }


                        // echo '</tr>';
                    }
                    // echo '</table>';
                    // echo 'There are ' . $counter . ' records in the file' . '<br>';
                    // echo 'There are ' . $invalid_counter . ' invalid records in the file';

                    // echo "<br>" . "==============================" . "<br>";
                    //loop through records after validation filtering to store it directly into database

                    foreach ($xlsx_arr as $k => $r) {
                        if (in_array($k, $invalid_records)) {
                            unset($xlsx_arr[$k]);
                        } else {
                            // echo json_encode($r) . ' ';

                            $message = $this->IncomeOutcomeModel->import_income($r);
                            if ($message != null) {
                                return false;
                            }
                            $ilogs = array(
                                "errors" => $error_logs,
                                "total_records" => $counter,
                                "total_invalids" => $invalid_counter,
                                "invalid_records" => $invalid_records,
                            );
                        }
                    }
                } else {
                    echo SimpleXLSX::parseError();
                }
                // echo '<pre>';
                // echo json_encode($log_arr);
                //delete file after parsing its data
                unlink($path);
                if ($ilogs['errors'] != []) {
                    foreach ($ilogs['errors'] as $ol) {
                        echo $ol;
                        echo "\r\n";
                    }
                } else {
                    echo $this->lang->line('All data records saved successfully');
                }
            }
        }
    }

    //handling upload of outcome xlsx file, parsing then processing its data to database
    public function excel_oupload()
    {
        if ($this->session->user_lang == 'english') {
            $this->lang->load('vars', 'english');
            $this->lang->load('msgs', 'english');
        } else {
            $this->lang->load('vars', 'arabic');
            $this->lang->load('msgs', 'arabic');
        }

        require_once 'assets/SimpleXLSX.php';
        $ologs = [];

        if (isset($_FILES['excel_ofile']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'xlsx';
            $config['max_size']      = 1048576; //total allowed size in bytes

            $filename = $_FILES["excel_ofile"]["name"];
            // echo $filename;

            $path = 'uploads\\' . $filename;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('excel_ofile')) {
                echo $this->upload->display_errors();
            } else {
                //parse xlsx file using simplexlsx script

                // echo '<h1>Parse income data</h1><pre>';
                if ($xlsx = SimpleXLSX::parse($path)) {
                    // echo '<h2>Parsing Result</h2>';
                    // echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

                    $dim = $xlsx->dimension();
                    $cols = $dim[0];

                    $counter = 0;
                    $invalid_records = array(0);

                    $error_logs = array();

                    $invalid_counter = 0;
                    //loop through rows
                    // '<pre>' . print_r($xlsx->rows()) . '</pre>';
                    $header = $xlsx->rows()[0];
                    // '<pre>' . print_r($header) . '</pre>';

                    $xlsx_arr = $xlsx->rows();
                    //remove first row in the xlx file
                    unset($xlsx_arr[0]);
                    foreach ($xlsx_arr as $k => $r) {
                        // if ($k == 0) continue; // skip first row
                        // echo $r[0] . $r[1] . $r[2] . $r[3];
                        $counter += 1;

                        // echo '<tr>';
                        // //loop through columns
                        // echo '<td>' . (isset($r) ? json_encode($r) : '&nbsp;') . '</td>';

                        //check for invalid date
                        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $r[0])) {
                            $invalid_counter += 1;
                            // echo "invalid date at " . $k . "th record" . '<br>';
                            // array_push($error_logs, "invalid date at " . $k . "th record");
                            array_push($error_logs, sprintf($this->lang->line('invalid date at (%s) th record'), $k += 1));

                            array_push($invalid_records, $k -= 1);
                        } else {
                        }
                        //check for invalid numbers
                        if (is_numeric($r[2]) && $r[2] >= 0) {
                        } else {

                            $invalid_counter += 1;
                            // echo "invalid number at " . $k . 'th record' . '<br>';
                            // array_push($error_logs, "invalid number at " . $k . "th record");
                            array_push($error_logs, sprintf($this->lang->line('invalid number at (%s) th record'), $k += 1));
                            array_push($invalid_records, $k -= 1);
                        }

                        //check for invalid categories
                        if ($r[1]) {

                            $query = $this->db->select('Name')->from('categories')->where('Name', $r[1])->where('Type', 'outcome')->get()->result();
                            if ($query == [] || $r[1] == '') {
                                $invalid_counter += 1;
                                // echo "invalid category at " . $k . 'th record' . '<br>';
                                // array_push($error_logs, "invalid category at " . $k . "th record");
                                array_push($error_logs, sprintf($this->lang->line('invalid category at (%s) th record'), $k += 1));
                                array_push($invalid_records, $k -= 1);

                                // echo $r[$i];
                            }
                        }


                        // echo '</tr>';
                    }
                    // echo '</table>';
                    // echo 'There are ' . $counter . ' records in the file' . '<br>';
                    // echo 'There are ' . $invalid_counter . ' invalid records in the file';

                    // echo "<br>" . "==============================" . "<br>";
                    //loop through records after validation filtering to store it directly into database

                    foreach ($xlsx_arr as $k => $r) {
                        if (in_array($k, $invalid_records)) {
                            unset($xlsx_arr[$k]);
                        } else {
                            // echo json_encode($r) . ' ';

                            $message = $this->IncomeOutcomeModel->import_outcome($r);
                            if ($message != null) {
                                // echo $message;
                                return false;
                            }

                            $ologs = array(
                                "errors" => $error_logs,
                                "total_records" => $counter,
                                "total_invalids" => $invalid_counter,
                                "invalid_records" => $invalid_records,
                            );
                        }
                    }
                } else {
                    echo SimpleXLSX::parseError();
                }
                // echo '<pre>';
                // echo json_encode($log_arr);
                //delete file after parsing its data
                unlink($path);
                if ($ologs['errors'] != []) {
                    // echo join($ologs['errors'], '  ');
                    foreach ($ologs['errors'] as $ol) {
                        echo $ol;
                        echo "\r\n";
                    }
                } else {
                    echo $this->lang->line('All data records saved successfully');
                }
            }
        }
    }
}
