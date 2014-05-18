<?php

/**
 * Description of update
 *
 * @author nelson
 */
require_once 'conn.db';
require_once './lists.php';
require_once './sms.php';

class update {

    private $dbh;
    private $lists;

    public function __construct() {
        $this->dbh = connect();
        $this->lists = new Lists();
        if (isset($_POST['update_member'])) {
            $this->updateMember();
        } else if (isset($_POST['update_activity'])) {
            $this->updateActivity();
        } else if (isset($_POST['update_membership_type'])) {
            $this->updateMembershipType();
        } else if (isset($_POST['update_membership_rate'])) {
            $this->updateMembershipRate();
        } else if (isset($_POST['update_subscription'])) {
            $this->updateSubscription();
        } else if (isset($_POST['update_emp'])) {
            $this->updateEmp();
        } else if (isset($_POST['update_payment'])) {
            $this->updatePayment();
        }
    }

    private function updateMember() {
        $query = "update member set names=?,gender=?,email=?,phoneno=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['names']);
        $stmt->bindParam(2, $_POST['gender']);
        $stmt->bindParam(3, $_POST['email']);
        $stmt->bindParam(4, $_POST['phoneno']);
        $stmt->bindParam(5, $_POST['id']);
        $stmt->execute();
        header('location:../admin/members/?msg=1');
    }

    private function updateActivity() {
        $query = "update activity set name=?,descpt=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['name']);
        $stmt->bindParam(2, $_POST['descpt']);
        $stmt->bindParam(3, $_POST['id']);
        $stmt->execute();
        header('location:../admin/activities/?msg=1');
    }

    private function updateMembershipType() {
        $query = "update membership_type set name=?,duration=?,descpt=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['name']);
        $stmt->bindParam(2, $_POST['duration']);
        $stmt->bindParam(3, $_POST['descpt']);
        $stmt->bindParam(4, $_POST['id']);
        $stmt->execute();
        header('location:../admin/mebershiptypes/?msg=1');
    }

    private function updateMembershipRate() {
        $query = "update membership_rate set amount=?,activity=?,membership=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['amount']);
        $stmt->bindParam(2, $_POST['activity']);
        $stmt->bindParam(3, $_POST['membership_type']);
        $stmt->bindParam(4, $_POST['id']);
        $stmt->execute();
        header('location:../admin/mebershiprates/?msg=1');
    }

    private function updateSubscription() {
        $time = $_SERVER['REQUEST_TIME'];
        $this->dbh->beginTransaction();
        $query = "update subscription set mebership_rate_id=?,member=?,start_time=?,end_time=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['membership_rate']);
        $stmt->bindParam(2, $_POST['member']);
        $stmt->bindParam(3, $_POST['startdate']);
        $stmt->bindParam(4, $_POST['enddate']);
        $stmt->bindParam(5, $_POST['id']);
        $stmt->execute();

        $query = "insert into payment_due set sid=?,member=?,to_pay=?,balance=?,stringdate=?,date=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['id']);
        $stmt->bindParam(2, $_POST['member']);
        $stmt->bindParam(3, $_POST['amount']);
        $stmt->bindParam(4, $_POST['amount']);
        $stmt->bindValue(5, date('D-d-M-Y', $time));
        $stmt->bindParam(6, $time);
        $stmt->execute();

        $this->dbh->commit();
        header('location:../admin/subscriptions/?msg=1');
    }

    private function updateEmp() {
        $query = "update employees set names=?,idno=?,mobile=?,gender=?,marital=?,job_type=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['names']);
        $stmt->bindParam(2, $_POST['idno']);
        $stmt->bindParam(3, $_POST['mobile']);
        $stmt->bindParam(4, $_POST['gender']);
        $stmt->bindParam(5, $_POST['marital']);
        $stmt->bindParam(6, $_POST['job_type']);
        $stmt->bindParam(7, $_POST['id']);
        $stmt->execute();
        header('location:../admin/employees/?msg=1');
    }

    private function updatePayment() {
        $time = $_SERVER['REQUEST_TIME'];
        $balance = ($_POST['to_pay'] - $_POST['amount']);

        $cleared = ($balance == 0 ? 1 : 0);

        $this->dbh->beginTransaction();
        $query = "update payment_due set balance=?,cleared=? where id=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $balance); //Balance from the previous pay
        $stmt->bindParam(2, $cleared);
        $stmt->bindParam(3, $_POST['id']);
        $stmt->execute();

        $query = "insert into transaction set sid=?,pid=?,member=?,amount=?,stringdate=?,date=?";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(1, $_POST['sid']);
        $stmt->bindValue(2, $_POST['id']);
        $stmt->bindParam(3, $_POST['member']);
        $stmt->bindParam(4, $_POST['amount']);
        $stmt->bindValue(5, date('D-d-M-Y', $time));
        $stmt->bindParam(6, $time);
        $stmt->execute();

        $query = "insert into transaction_balance set sid=?,pid=?,member=?,balance=?,stringdate=?,cleared=?,date=?";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindValue(1, $_POST['sid']);
        $stmt->bindValue(2, $_POST['id']);
        $stmt->bindParam(3, $_POST['member']);
        $stmt->bindParam(4, $balance);
        $stmt->bindValue(5, date('D-d-M-Y', $time));
        $stmt->bindParam(6, $cleared);
        $stmt->bindParam(7, $time);
        $stmt->execute();

        $this->dbh->commit();

        /** Notify * */
        //Email
        $this->notifyPayerEmail($_POST['member'], $_POST['amount'], $balance);

        //Text message
        $this->notifyPayerSMS($_POST['member'], $_POST['amount'], $balance);

        header('location:../admin/payments/?msg=1');
    }

    function notifyPayerEmail($member, $amount, $due) {
//        $email = $this->lists->fetchByID('member', 'email', 'names', "'{$member}'");
//        $subject = "Oasis Payment Receipt";
////        $message = '<html><title>Payment Receipt</title><body>'
//        $message = 'This is a receipt for your <a href="#">Oasis Membership</a> of KES. ' . number_format($amount, 2) . ''
//                . 'due payment is KES. ' . number_format($due, 2) . '. If you have any questions, please contact us anytime'
//                . 'Thank you for your business.'
//                . '<hr />'
//                . '<a href="#">Oasis Fitness Salon and Spa</a>'
//                . '<br />'
//                . 'Amount KES. ' . number_format($amount, 2) . ''
//                . '<hr />'
//                . '<a href="#">Oasis Fitness Salon and Spa</a>'
//                . '51986-00100 GPO Nairobi'
//                . '0710318593'
//                . 'oasisfitnesskenya@gmail.com'
//                . '5th Floor, Teleposta Towers'
//                . 'Kenya Nairobi';
////                . '</body></html>';
////        // To send HTML mail, the Content-type header must be set
////        $headers = 'MIME-Version: 1.0' . "\r\n";
////        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
////
////// Additional headers
////        $headers .= 'From: Oasis Fitness Salon and Spa <palmlist@palmlist.com>' . "\r\n";
//// Mail it
//        $headers = "From: palmlist@palmlist.com";
//        $headers .= "\r\nReply-To: palmlist@palmlist.com";
//        $headers .= "\r\nX-Mailer: PHP/" . phpversion();
//        echo mail('gakurumaina@gmail.com', 'Foo', 'Payment Receipt');
    }

    function notifyPayerSMS($member, $amount) {
        $phoneno = $this->lists->fetchByID('member', 'phoneno', 'names', "'{$member}'");
        $phoneno = preg_replace("/^0/", "+254", $phoneno);
        $message = 'We have received your payment of KES. ' . number_format($amount, 2) . ' Thank you for your business Oasis';
        sendSMS($phoneno, $message, 'receipt');
    }

}

new update();
