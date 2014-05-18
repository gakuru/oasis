<?php

/**
 * Description of charts
 *
 * @author nelson
 */
require_once '../general/conn.db';

class charts {

    private $dbh;

    public function __construct($rqid) {
        $this->dbh = connect();
        switch ($rqid) {
            case 0:
                $this->subsDistribution();
                break;
            case 1:
                $this->dailyActivityIncomeDistribution();
                break;
            case 2:
                $this->dailyIncomeDistribution();
                break;
            case 3:
                $this->dailyBalanceIncomeDistribution();
                break;
        }
    }

    private function subsDistribution() {
        $query = "select count(*)`activity_total`,act.name from subscription as s inner join activity as act on act.id where s.mebership_rate_id=act.id  group by s.mebership_rate_id order by s.mebership_rate_id;";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $dataset[] = array($row['activity_total']);
            $datasetdates[] = array($row['name']);
        }
        $output = array("dates" => $datasetdates, "series" => $dataset);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        file_put_contents('../admin/files/subscribers.json', json_encode($output, JSON_NUMERIC_CHECK));
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        echo json_encode($output, JSON_NUMERIC_CHECK);
    }

    private function dailyActivityIncomeDistribution() {
        $query = "select sum(`amount`)`paid_total`,stringdate from `transaction` group by sid order by stringdate;";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $dataset[] = array($row['paid_total']);
            $datasetdates[] = array($row['stringdate']);
        }
        $output = array("dates" => $datasetdates, "series" => $dataset);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        file_put_contents('../admin/files/daily_act_dist.json', json_encode($output, JSON_NUMERIC_CHECK));
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        echo json_encode($output, JSON_NUMERIC_CHECK);
    }

    private function dailyIncomeDistribution() {
        $query = "select sum(t.amount)`paid_total`,t.stringdate from `transaction` as t group by t.stringdate order by t.stringdate";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $dataset[] = array($row['paid_total']);
            $datasetdates[] = array($row['stringdate']);
        }
        $output = array("dates" => $datasetdates, "series" => $dataset);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        file_put_contents('../admin/files/daily_income_dist.json', json_encode($output, JSON_NUMERIC_CHECK));
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        echo json_encode($output, JSON_NUMERIC_CHECK);
    }

    private function dailyBalanceIncomeDistribution() {
        $query = "select sum(t.amount)`paid_total`,sum(tb.balance)`balance_total`,t.stringdate from `transaction` as t inner join transaction_balance as tb on tb.id where t.id=tb.id group by t.stringdate order by t.stringdate;";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $dataset_income[] = array($row['paid_total']);
            $dataset_balance[] = array($row['balance_total']);
            $datasetdates[] = array($row['stringdate']);
        }
        $output = array("dates" => $datasetdates, "income" => $dataset_income, "balance" => $dataset_balance);
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        file_put_contents('../admin/files/daily_income_bal_dist.json', json_encode($output, JSON_NUMERIC_CHECK));
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');
        echo json_encode($output, JSON_NUMERIC_CHECK);
    }

}

new charts($_POST['rqid']);
