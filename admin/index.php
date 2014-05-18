<?php
require_once '../general/topbar.php';
!isset($_SESSION['user']) ? header('location:../') : NULL;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar" id="links">
                <li class="active"><a class="links" href="dash/">Dashboard</a></li>
                <li><a class="links" href="members/">Members</a></li>
                <li><a class="links" href="activities/">Activities</a></li>
                <li><a class="links" href="mebershiptypes/">Membership types</a></li>
                <li><a class="links" href="subscriptions/">Subscriptions</a></li>
                <li><a class="links" href="mebershiprates/">Membership rates</a></li>
                <li><a class="links" href="payments/">Payments</a></li>
                <!--<li><a class="links" href="feeds/">Extras</a></li>-->
                <!--<li><a class="links" href="employees/">Employees</a></li>-->
                <!--<li><a href="notices/">Notices</a></li>-->
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div id="loader_div">
                <iframe id="loader_frame" src="dash/"></iframe>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../libs/js/jquery-2.1.0.min.js"></script>
<script>
    $(function($) {
        var r = $('#loader_frame');
        $('.links').on('click', function(e) {
            $('.links').parent().removeClass('active');
            $(this).parent().addClass('active');
            e.preventDefault();
            r.attr('src', $(this).attr('href'));
        });
    });
</script>
