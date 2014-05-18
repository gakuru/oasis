<?php

/**
 * Description of member_subscriptions
 *
 * @author nelson
 */
require_once '../../general/conn.db';

class member_subscriptions {

    private $dbh = NULL;

    public function __construct($rqid) {
        $this->dbh = connect();
        switch ($rqid) {
            case 0:
                $this->getMemberSubscriptions();
                break;
            case 1:
                $this->getMemberPayments();
                break;
        }
    }

    function getMemberSubscriptions() {
        $query = "select distinct s.id as sid,s.mebership_rate_id,mr.activity,mr.amount,mr.membership from subscription as s inner join membership_rate as mr on mr.id where s.mebership_rate_id=mr.id and s.member=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['member']);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);
    }

    function getMemberPayments() {
        $query = "select t.id,t.amount,tb.balance,t.stringdate,tb.cleared from `transaction` as t inner join transaction_balance tb where t.id=tb.id and t.pid=?;";
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(1, $_POST['id']);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_NUMERIC_CHECK);
    }

}

new member_subscriptions($_POST['rqid']);
