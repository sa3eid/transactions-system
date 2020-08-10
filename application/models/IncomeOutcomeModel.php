<?php

// model for handling both income outcome tabs saving data into transactions table
class IncomeOutcomeModel extends CI_Model
{

  //insert income into transactions table
  public function insert_income($cat_id, $value, $id, $income_date, $income_comment)
  {
    $this->db->insert('transactions', array("UserId" => $id, "CategoryId" => $cat_id, "Amount" => $value, "Date" => $income_date, "Comment" => $income_comment));
  }

  //insert outcome into transactions table

  public function insert_outcome($cat_id, $value, $id, $outcome_date, $outcome_comment)
  {
    $this->db->insert('transactions', array("UserId" => $id, "CategoryId" => $cat_id, "Amount" => $value, "Date" => $outcome_date, "Comment" => $outcome_comment));
  }

  // get income Name & Amount from transactions table
  public function get_income($user_id, $income_id)
  {
    $query = $this->db->from('transactions')->join('categories', 'transactions.CategoryId = categories.id')
      ->select('transactions.Id, categories.Name, transactions.Amount')->where('Id', $income_id)->where('UserId', $user_id)->get();
    return $query->result();
  }
  //update income data into transactions table
  public function update_income($income_cat_id, $trans_id, $income_amount, $income_date, $income_comment)
  {
    $data = array(
      "CategoryId" => $income_cat_id,
      'Amount'     => $income_amount,
      "Date"       => $income_date,
      "Comment"    => $income_comment,
    );

    //update the transactions table
    $this->db->where('Id', $trans_id)->update('transactions', $data);

    // echo $this->db->last_query();
  }

  //update outcome data into transactions table

  public function update_outcome($outcome_cat_id, $trans_id, $outcome_amount, $outcome_date, $outcome_comment)
  {
    $data = array(
      "CategoryId" => $outcome_cat_id,
      'Amount'     => $outcome_amount,
      "Date"       => $outcome_date,
      "Comment"    => $outcome_comment,
    );

    $this->db->where('Id', $trans_id)->update('transactions', $data);
  }

  //select income cateogry from cateogries table

  public function select_income_category($term = "")
  {
    $cdata = array();
    $query = $this->db->from('categories')->select('Id, Name')->like('Type', "income")->or_like('Type', 'both')->like('Name', $term)->get();
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

  public function select_outcome_category($term = "")
  {
    $cdata = array();
    $query = $this->db->from('categories')->select('Id, Name')->like('Type', 'outcome')->or_like('Type', 'both')->like('Name', $term)->get();
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

  public function delete_cat($del_id)
  {
    if ($this->session->user_lang == 'english') {
      $this->lang->load('msgs', 'english');
    } else {
      $this->lang->load('msgs', 'arabic');
    }
    //del_id is meant to the deleted catgory id

    //checking if category is used in transactions or not, if not used in transactions, then we can delete this category
    if ($this->db->select('CategoryId')->from('transactions')->where('CategoryId', $del_id)->get()->num_rows() == 0) {
      $this->db->where('Id', $del_id)->delete('categories');
    } else {
      return $this->lang->line('category cant be deleted, delete transactions of this category first!!');
    }
  }

  public function delete_trans($del_tid)
  {
    //del_tid is meant to the deleted transaction id
    $this->db->where('Id', $del_tid)->delete('transactions');
  }

  //getting SUM(Amount) as asum foreach category grouped by CategoryId for income
  public function isubtotal($filters, $user_id)
  {
    $sql = "SELECT categories.Name, categories.Type, SUM(transactions.Amount) as asum
            FROM transactions
            INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE 1 ";

    if (!empty($filters['oamount_f'])) {
      $sql .= " AND Amount >=" . $filters['iamount_f'];
    }

    if (!empty($filters['oamount_t'])) {
      $sql .= " AND Amount <=" . $filters['iamount_t'];
    }

    if (!empty($filters['odate_f'])) {
      $sql .= " AND Date >=" . $filters['idate_f'];
    }

    if (!empty($filters['odate_t'])) {
      $sql .= " AND Date <=" . $filters['idate_t'];
    }

    if (!empty($filters['icat'])) {
      //convert array of category ids to string
      $ids = implode(",", $filters['icat']);
      $sql .= " AND CategoryId IN (" . $ids . ")";
    }
    $sql .= " AND transactions.UserId = '$user_id'";
    $sql .= "  GROUP BY CategoryId ";
    $query = $this->db->query($sql);

    return $query->result();
  }

  //getting SUM(Amount) as asum foreach category grouped by CategoryId for outcome
  public function osubtotal($filters, $user_id)
  {
    $sql = "SELECT categories.Name, categories.Type, SUM(transactions.Amount) as asum
            FROM transactions
            INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE 1 ";

    if (!empty($filters['oamount_f'])) {
      $sql .= " AND Amount >=" . $filters['oamount_f'];
    }

    if (!empty($filters['oamount_t'])) {
      $sql .= " AND Amount <=" . $filters['oamount_t'];
    }

    if (!empty($filters['odate_f'])) {
      $sql .= " AND Date >=" . $filters['odate_f'];
    }

    if (!empty($filters['odate_t'])) {
      $sql .= " AND Date <=" . $filters['odate_t'];
    }

    if (!empty($filters['ocat'])) {
      //convert array of category ids to string
      $ids = implode(",", $filters['ocat']);
      $sql .= " AND CategoryId IN (" . $ids . ")";
    }
    $sql .= " AND transactions.UserId = '$user_id'";
    $sql .= " GROUP BY CategoryId";
    $query = $this->db->query($sql);

    return $query->result();
  }

  //processing income xlsx file and store data into database
  public function import_income($record)
  {

    // echo json_encode($record);
    $cat_id = $this->db->select('Id')->from('categories')->where('Name', $record[1])->get()->row_array();
    $transaction_date = $this->db->select('Date')->from('transactions')->where('Date', $record[0])->get()->row_array();
    $transaction_amount = $this->db->select('Amount')->from('transactions')->where('Amount', $record[2])->get()->row_array();
    $transaction_comment = $this->db->select('Comment')->from('transactions')->where('Comment', $record[3])->get()->row_array();
    if ($cat_id != null) {
      if ($transaction_date != null && $transaction_amount != null && $transaction_comment != null) {
        return "record duplicated";
      }
      $this->db->insert('transactions', array("UserId" => $this->session->user_id, "CategoryId" => $cat_id['Id'], "Amount" => $record[2], "Date" => $record[0], "Comment" => $record[3]));
    }

    // echo json_encode($cat_id['Id']);
    // echo $this->db->last_query();
  }

  public function import_outcome($record)
  {
    $cat_id = $this->db->select('Id')->from('categories')->where('Name', $record[1])->get()->row_array();
    $transaction_date = $this->db->select('Date')->from('transactions')->where('Date', $record[0])->get()->row_array();
    $transaction_amount = $this->db->select('Amount')->from('transactions')->where('Amount', $record[2])->get()->row_array();
    $transaction_comment = $this->db->select('Comment')->from('transactions')->where('Comment', $record[3])->get()->row_array();
    if ($cat_id != null) {
      if ($transaction_date != null && $transaction_amount != null && $transaction_comment != null) {
        return "record duplicated";
      }
      $this->db->insert('transactions', array("UserId" => $this->session->user_id, "CategoryId" => $cat_id['Id'], "Amount" => $record[2], "Date" => $record[0], "Comment" => $record[3]));
    }
  }
}
