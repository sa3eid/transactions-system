<?php

// model for handling income statistics filtering
class StatisticsModel extends CI_Model
{

    public function filterIncomeStatistics($filters, $user_id)
    {

        $sql = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum
        FROM transactions
        INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE categories.Type= 'income' AND transactions.UserId = '$user_id'";

        if (!empty($filters['sidate_f'])) {
            $sql .= " AND Date >=" . "'" . $filters['sidate_f'] . "'";
        }

        if (!empty($filters['sidate_t'])) {
            $sql .= " AND Date <=" . "'" . $filters['sidate_t'] . "'";
        }

        if (!empty($filters['sicat'])) {
            //convert array of category ids to string
            $ids = implode(",", $filters['sicat']);
            $sql .= " AND CategoryId IN (" . $ids . ")";
        }
        $sql .= " GROUP BY CategoryId";
        // $query = $this->db->query($sql);

        // echo $this->db->last_query();

        //other sql group by date
        $isql = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum
        FROM transactions
        INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE categories.Type= 'income' AND transactions.UserId = '$user_id'";

        if (!empty($filters['sidate_f'])) {
            $isql .= " AND Date >=" . "'" . $filters['sidate_f'] . "'";
        }

        if (!empty($filters['sidate_t'])) {
            $isql .= " AND Date <=" . "'" . $filters['sidate_t'] . "'";
        }

        if (!empty($filters['sicat'])) {
            //convert array of category ids to string
            $ids = implode(",", $filters['sicat']);
            $isql .= " AND CategoryId IN (" . $ids . ")";
        }
        $isql .= " GROUP BY transactions.Date";

        $sql_all = array(
            "sql" => $sql,
            "isql" => $isql
        );


        return $sql_all;
    }

    public function filterOutcomeStatistics($filters, $user_id)
    {

        $sql = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum
        FROM transactions
        INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE categories.Type= 'outcome' AND  transactions.UserId = '$user_id'";

        if (!empty($filters['sodate_f'])) {
            $sql .= " AND Date >=" . "'" . $filters['sodate_f'] . "'";
        }

        if (!empty($filters['sodate_t'])) {
            $sql .= " AND Date <=" . "'" . $filters['sodate_t'] . "'";
        }

        if (!empty($filters['socat'])) {
            //convert array of category ids to string
            $ids = implode(",", $filters['socat']);
            $sql .= " AND CategoryId IN (" . $ids . ")";
        }
        $sql .= " GROUP BY CategoryId";
        // $query = $this->db->query($sql);

        // echo $this->db->last_query();

        //other sql group by date
        $isql = "SELECT categories.Name, transactions.Amount, transactions.Date, SUM(transactions.Amount) as tsum
        FROM transactions
        INNER JOIN categories ON categories.Id = transactions.CategoryId WHERE categories.Type= 'outcome' AND transactions.UserId = '$user_id'";

        if (!empty($filters['sodate_f'])) {
            $isql .= " AND Date >=" . "'" . $filters['sodate_f'] . "'";
        }

        if (!empty($filters['sodate_t'])) {
            $isql .= " AND Date <=" . "'" . $filters['sodate_t'] . "'";
        }

        if (!empty($filters['socat'])) {
            //convert array of category ids to string
            $ids = implode(",", $filters['socat']);
            $isql .= " AND CategoryId IN (" . $ids . ")";
        }
        $isql .= " GROUP BY transactions.Date";

        $sql_all = array(
            "sql" => $sql,
            "isql" => $isql
        );


        return $sql_all;
    }
}
