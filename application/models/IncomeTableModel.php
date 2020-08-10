<?php

// model for handling income table
class IncomeTableModel extends CI_Model
{

    public function allposts_count($id)
    {
        $query = $this
            ->db->select('transactions.Id, categories.Name, transactions.Amount')
            ->from('transactions')->join('categories', 'categories.id = transactions.CategoryId')
            ->where('transactions.UserId', $id)->like('categories.Type', 'income')
            ->get();

        return $query->num_rows();
    }

    public function allposts($limit, $start, $col, $dir, $filters = "", $id)
    {

        if ($filters) {

            //return only filtered records

            $db = $this->db->select('transactions.Id, categories.Name, transactions.Amount, transactions.Date, transactions.Comment')
                ->from('transactions')->join('categories', 'categories.Id = transactions.CategoryId')
                ->where('transactions.UserId', $id)->like('categories.Type', 'income')
                ->limit($limit, $start)
                ->order_by($col, $dir);

            if (!empty($filters['amount_from'])) {
                $db->where('Amount >=', $filters['amount_from']);
            }

            if (!empty($filters['amount_to'])) {
                $db->where('Amount <=', $filters['amount_to']);
            }

            if (!empty($filters['date_from'])) {
                $db->where('Date >=', $filters['date_from']);
            }

            if (!empty($filters['date_to'])) {
                $db->where('Date <=', $filters['date_to']);
            }

            if (!empty($filters['categories'])) {

                //convert array of category ids to string
                $db->where_in('CategoryId', $filters['categories']);
            }

            $query = $db->limit($limit, $start)
                ->order_by($col, $dir)->get();
            return $query->result();
            // echo $this->db->last_query();
        } else {
            // if filter not set return all records to table
            $query = $this->db->select('transactions.Id, categories.Name, transactions.Amount, transactions.Date, transactions.Comment')
                ->from('transactions')->join('categories', 'categories.Id = transactions.CategoryId')
                ->where('transactions.UserId', $id)->like('categories.Type', 'income')
                ->limit($limit, $start)
                ->order_by($col, $dir)->get();
            return $query->result();
        }
    }
}
