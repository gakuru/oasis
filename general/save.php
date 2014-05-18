<?php

/**
 * Description of save
 *
 * @author nelson
 */
require_once 'conn.db';

class Save {

    private $dbh;

    public function __construct() {
        $this->dbh = connect();

        if (isset($_POST[ 'save_activity'])) {
            $this->saveActivity();
        } else if (isset($_POST['save_member'])) {
            $this->saveMember();
        } else if (isset($_POST['save_membership_type'])) {
            $this->saveMembershipType();
        } else if (isset($_POST['save_payment'])) {
            $this->savePayment();
        } else if (isset($_POST['save_new_subscription'])) {
            $this->saveSubscription();
        } else if (isset($_POST['save_membership_rate'])) {
            $this->saveMembershipRate();
        } else if (isset($_POST['save_emp'])) {
            $this->saveEmployee();
        } else if (isset($_POST['save_emp_sal'])) {
            $this->saveEmployeeSalaray();
        } else if (isset($_POST['save_tenant_rent'])) {
            $this->saveTenantRent();
        } else if (isset($_POST['send_save_notice'])) {
            $this->send_save_notice();
        }
    }

    private function saveActivity() {
        $query = "insert into activity set name=?,descpt=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['name']);
        $stmt->bindParam(2, $_POST['descpt']);
        $stmt->bindParam(3, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/activities/?msg=0');
    }

    private function saveMember() {
        $query = "insert into member set names=?,gender=?,email=?,phoneno=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['names']);
        $stmt->bindParam(2, $_POST['gender']);
        $stmt->bindParam(3, $_POST['email']);
        $stmt->bindParam(4, $_POST['phoneno']);
        $stmt->bindParam(5, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        $total_members = file_get_contents('../admin/files/members.oas');
        $total_members++;
        file_put_contents('../admin/files/members.oas', $total_members);
        header('location:../admin/members/?msg=0');
    }

    private function saveMembershipType() {
        $query = "insert into membership_type set name=?,duration=?,descpt=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['name']);
        $stmt->bindParam(2, $_POST['duration']);
        $stmt->bindParam(3, $_POST['descpt']);
        $stmt->bindParam(4, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/mebershiptypes/?msg=0');
    }

    private function savePayment() {
        $time = $_SERVER['REQUEST_TIME'];
        $this->dbh->beginTransaction();
        $query = "insert into payment set sid=?,activity=?,member=?,to_pay=?,amount=?,stringdate=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['subs']);
        $stmt->bindParam(2, $_POST['activity']);
        $stmt->bindParam(3, $_POST['member']);
        $stmt->bindParam(4, $_POST['to_pay']);
        $stmt->bindParam(5, $_POST['paid']);
        $stmt->bindValue(6, date('D-d-M-Y', $time));
        $stmt->bindParam(7, $time);
        $stmt->execute();

        $query = "insert into transactions set sid=?,activity=?,member=?,amount=?,stringdate=?,date=?";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(1, $_POST['subs']);
        $stmt->bindParam(2, $_POST['activity']);
        $stmt->bindParam(3, $_POST['member']);
        $stmt->bindParam(4, $_POST['paid']);
        $stmt->bindValue(5, date('D-d-M-Y', $time));
        $stmt->bindParam(6, $time);
        $stmt->execute();
        $this->dbh->commit();
        header('location:../admin/payments/?msg=0');
    }

    private function saveSubscription() {
        $this->dbh->beginTransaction();
        $time = $_SERVER['REQUEST_TIME'];
        $query = "insert into subscription set mebership_rate_id=?,member=?,start_time=?,end_time=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['membership_rate']);
        $stmt->bindParam(2, $_POST['member']);
        $stmt->bindParam(3, $_POST['startdate']);
        $stmt->bindParam(4, $_POST['enddate']);
        $stmt->bindParam(5, $time);
        $stmt->execute();

        $query = "insert into payment_due set sid=?,member=?,to_pay=?,balance=?,stringdate=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(1, $this->dbh->lastInsertId());
        $stmt->bindParam(2, $_POST['member']);
        $stmt->bindParam(3, $_POST['amount']);
        $stmt->bindParam(4, $_POST['amount']);
        $stmt->bindValue(5, date('D-d-M-Y', $time));
        $stmt->bindParam(6, $time);
        $stmt->execute();

        $this->dbh->query("update member set subscribed=1 where names='" . $_POST['member'] . "' ;");

        $this->dbh->commit();

        $total_subscriptions = file_get_contents('../admin/files/subscriptions.oas');
        $total_subscriptions++;
        file_put_contents('../admin/files/subscriptions.oas', $total_subscriptions);
        header('location:../admin/subscriptions/?msg=0');
    }

    private function saveMembershipRate() {
        $query = "insert into membership_rate set amount=?,activity=?,membership=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['amount']);
        $stmt->bindParam(2, $_POST['activity']);
        $stmt->bindParam(3, $_POST['membership_type']);
        $stmt->bindParam(4, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/mebershiprates/?msg=0');
    }

    private function saveIssue() {
        $query = "insert into maintenance_table set hid=?,tid=?,issue=?,cost=?,serviced_by=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['hid']);
        $stmt->bindParam(2, $_POST['tid']);
        $stmt->bindParam(3, $_POST['issue']);
        $stmt->bindParam(4, $_POST['cost']);
        $stmt->bindParam(5, $_POST['server']);
        $stmt->bindParam(6, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/house/maintenance/?msg=0');
    }

    private function saveEmployee() {
        $query = "insert into employees set names=?,idno=?,mobile=?,gender=?,marital=?,job_type=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['names']);
        $stmt->bindParam(2, $_POST['idno']);
        $stmt->bindParam(3, $_POST['mobile']);
        $stmt->bindParam(4, $_POST['gender']);
        $stmt->bindParam(5, $_POST['marital']);
        $stmt->bindParam(6, $_POST['job_type']);
        $stmt->bindParam(7, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/employees/?msg=0');
    }

    function saveEmployeeSalaray() {
        $query = "insert into salary set empid=?,amount=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['empid']);
        $stmt->bindParam(2, $_POST['amount']);
        $stmt->bindParam(3, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/salary/?msg=0');
    }

    function saveTenantRent() {
        $query = "insert into rent set tid=?,hid=?,amount=?,slip_no=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['tid']);
        $stmt->bindParam(2, $_POST['house']);
        $stmt->bindParam(3, $_POST['amount']);
        $stmt->bindParam(4, $_POST['slip_no']);
        $stmt->bindParam(5, $_SERVER['REQUEST_TIME']);
        $stmt->execute();
        header('location:../admin/rent/?msg=0');
    }

    /** Get the extension of the image * */
    function getExtension($mimetype) {
        $spl = explode("/", $mimetype);
        return '' . $spl[1];
    }

}

new Save();
