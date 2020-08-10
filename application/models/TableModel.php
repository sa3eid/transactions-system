<?php

// model for handling categories table
class TableModel extends CI_Model
{

    public function allposts_count()
    {
        $query = $this
            ->db
            ->get('categories');

        return $query->num_rows();
    }

    public function allposts($limit, $start, $col, $dir, $filters = "", $user_id)
    {

        if ($filters) {

            //return only filtered records
            $db = $this->db->select('Id, Name, Type')->from('categories')->where('UserId', $user_id)

                ->like('Name', $filters['name']);

            $query = $db->limit($limit, $start)
                ->order_by($col, $dir)->get();
            return $query->result();
            // echo $this->db->last_query();
        } else {
            // if filter not set return all records to table
            $query = $this
                ->db
                ->select('Id, Name, Type')->from('categories')->where('UserId', $user_id)
                ->limit($limit, $start)
                ->order_by($col, $dir)
                ->get('categories');
            return $query->result();
        }
    }

    public function posts_search($limit, $start, $search, $col, $dir)
    {
        $query = $this
            ->db
            ->like('Name', $search)
            ->or_like('Type', $search)
            ->limit($limit, $start)
            ->order_by($col, $dir)
            ->get('categories');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function posts_search_count($search)
    {
        $query = $this
            ->db
            ->like('Name', $search)
            ->or_like('Type', $search)
            ->get('categories');

        return $query->num_rows();
    }
}
