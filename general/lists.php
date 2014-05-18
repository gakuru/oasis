<?php

require_once 'conn.db';

/**
 * 
 * @author Gakuru <gakuru@oakapp.co>
 * 
 */
class Lists {

    private $dbh = NULL;

    public function __construct() {
        $this->dbh = connect();
    }

    function notifyPayerEmail($member, $amount, $due) {
        $email = $this->fetchByID('member', 'email', 'names', "'{$member}'");
        $message = '<html><title>Payment Receipt</title><body>'
                . 'This is a receipt for your <a href="#">Oasis Membership</a> of KES. ' . number_format($amount, 2) . ''
                . 'due payment is KES. ' . number_format($due, 2) . '. If you have any questions, please contact us anytime'
                . 'Thank you for your business.'
                . '<hr />'
                . '<a href="#">Oasis Fitness Salon and Spa</a>'
                . '<br />'
                . 'Amount KES. ' . number_format($amount, 2) . ''
                . '<hr />'
                . '<a href="#">Oasis Fitness Salon and Spa</a>'
                . '51986-00100 GPO Nairobi'
                . '0710318593'
                . 'oasisfitnesskenya@gmail.com'
                . '5th Floor, Teleposta Towers'
                . 'Kenya Nairobi'
                . '</body></html>';
        echo $message;
    }

    function notifyPayerSMS($member, $amount) {
        $phoneno = $this->fetchByID('member', 'phoneno', 'names', "'{$member}'");
        $message = 'We have received your payment of KES. ' . number_format($amount, 2) . ' Thank you for your business Oasis';
        echo $message;
        echo '<br />';
        echo strlen($message);
    }

    function listActivities() {
        $query = "select * from activity;";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function listPayments($cleared) {
        $query = "select * from payment_due where cleared=? group by member;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $cleared);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function listMembers() {

        $query = "select * from member where deleted=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(1, FALSE);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function listEmployees() {

        $query = "select * from employees;";
        $result = $this->dbh->query($query);
        if ($result->rowCount() > 0) {
            $count = 0;
            echo '<table class="table table-condensed table-striped table-hover"> <thead><th>'
            . '<td>Names</td>'
            . '<td>ID No</td>'
            . '<td>Mobile</td>'
            . '<td>Gender</td>'
            . '<td>Married</td>'
            . '<td>Job Type</td>'
            . '<td>Employement Date</td>'
            . '<td>Operations</td>'
            . '</th></thead><tbody>';
            foreach ($result as $row) {
                echo '<tr>'
                . '<td>' . ++$count . '</td>'
                . '<td>' . $row['names'] . '</td>'
                . '<td>' . $row['idno'] . '</td>'
                . '<td>' . $row['mobile'] . '</td>'
                . '<td>' . ($row['gender'] == FALSE ? 'Male' : 'Female') . '</td>'
                . '<td>' . ($row['marital'] == FALSE ? 'Single' : 'Married') . '</td>'
                . '<td>' . $row['job_type'] . '</td>'
                . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                . '<td>'
                . '<a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Edit</a>'
                . '&emsp;'
                . '<a class="glyphicon glyphicon-remove btn btn-danger" href="delete.php?id=' . $row['id'] . '"> Delete</a>'
                . '</td>'
                . '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo 'No saved employees yet <a href="new.php" >Save a new employee</a>';
        }
    }

    function listEmployeeSalary() {

        $query = "select * from salary where empid=" . $_POST['sempid'] . " ;";
        $result = $this->dbh->query($query);
        $emp_name = fetchByID('employees', 'names', 'id', $_POST['sempid']);
        echo '<p>Salaries for ' . $emp_name . '</p>';
        if ($result->rowCount() > 0) {
            $count = 0;
            echo '<table class="table table-condensed table-striped table-hover"> <thead><th>'
            . '<td>Amount</td>'
            . '<td>Payment for</td>'
            . '<td>Payment Date</td>'
            . '</th></thead><tbody>';
            foreach ($result as $row) {
                echo '<tr>'
                . '<td>' . ++$count . '</td>'
                . '<td>' . number_format($row['amount']) . '</td>'
                . '<td>' . date('M-Y', $row['date']) . '</td>'
                . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                . '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo 'No salaries made to ' . $emp_name . ' yet <a href="new.php" >Save a new salary</a>';
        }
    }

    function membershipTypes() {

        $query = "select * from membership_type";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMembershipRates() {

        $query = "select * from membership_rate;";
        $result = $this->dbh->query($query);
        if ($result->rowCount() > 0) {
            $count = 0;
            echo
            '<table class="table table-condensed table-striped table-hover"> <thead><th>'
            . '<td>Amount</td>'
            . '<td>Activity</td>'
            . '<td>Membership Type</td>'
            . '<td>Date Saved</td>'
            . '<td>Operations</td>'
            . '</th></thead><tbody>';
            foreach ($result as $row) {
                echo '<tr>'
                . '<td>' . ++$count . '</td>'
                . '<td>' . $row['amount'] . '</td>'
                . '<td>' . $row['activity'] . '</td>'
                . '<td>' . $row['membership'] . '</td>'
                . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                . '<td>'
                . '<a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Edit</a>'
                . '&emsp;'
                . '<a class="glyphicon glyphicon-remove btn btn-danger" href="delete.php?id=' . $row['id'] . '"> Delete</a>'
                . '</td>'
                . '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo 'No pricing rates saved yet <a href="new.php" >Add a new rate</a>';
        }
    }

    function getSubscriptions() {
        $query = "select * from subscription;";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Helper functions * */
    function fetchByID($table, $column, $filt_col, $id) {
        $stmt = $this->dbh->prepare("select $column from $table where $filt_col=$id;");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    /** Helper functions * */
    function fetchByString($table, $column, $filt_col, $id) {
        $stmt = $this->dbh->prepare("select $column from $table where $filt_col='$id';");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_NUM);
        return $result[0];
    }

    function comboMembershipTypes($preselect = NULL) {
        $query = "select id,name from membership_type order by name;";

        $result = $this->dbh->query($query);
        echo '<select name="membership_type"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['name'] . '" ' . ($preselect == $row['name'] ? 'selected="selected"' : NULL) . '>' . $row['name'] . '</option>';
        }
        echo '</select>';
    }

    function comboMembers($subscribed = TRUE, $preselect = NULL) {
        $query = "select id,names from member where subscribed=? order by names;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $subscribed);
        $stmt->execute();
        $result = $stmt->fetchAll();
        echo '<select name="member" id="member"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['names'] . '" ' . ($preselect == $row['names'] ? 'selected="selected"' : NULL) . ' >' . $row['names'] . '</option>';
        }
        echo '</select>';
    }

    function comboMemberSubscribers($preselect = NULL) {
        $query = "select member,id from subscription group by member order by member";

        $result = $this->dbh->query($query);
        echo '<select name="member"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '" ' . ($preselect == $row['member'] ? 'selected="selected"' : NULL) . ' >' . $row['member'] . '</option>';
        }
        echo '</select>';
    }

    function comboActivities($preselect = NULL) {
        $query = "select id,name from activity order by name";

        $result = $this->dbh->query($query);
        echo '<select name="activity"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['name'] . '" ' . ($preselect == $row['name'] ? 'selected="selected"' : NULL) . '>' . $row['name'] . '</option>';
        }
        echo '</select>';
    }

    function comboMembershipRates($preselect = NULL) {
        $query = "select id,activity,membership,amount from membership_rate order by activity";

        $result = $this->dbh->query($query);
        echo '<select id="membership_rate" name="membership_rate"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option amount="' . $row['amount'] . '" label="' . $this->fetchByID('membership_type', 'duration', 'name', "'{$row['membership']}'") . '" value="' . $row['id'] . '" ' . ($preselect == $row['id'] ? 'selected="selected"' : NULL) . '>' . $row['activity'] . ' ' . $row['membership'] . ' @ ' . $row['amount'] . '</option>';
        }
        echo '</select>';
    }

    function comboEmployees() {
        $result = $this->dbh->query("select id,names from employees");
        echo '<select name="empid" id="emp"> <option value=-1>Select</option>';
        foreach ($result as $row) {
            echo '<option value="' . $row['id'] . '">' . $row['names'] . '</option>';
        }
        echo '</select>';
    }

}

new Lists();
