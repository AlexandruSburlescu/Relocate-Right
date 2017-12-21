<div class="col-3 col-sm12 container" id="lreel">
    <div class = "lreel">
        <div class="row">
            <div class="heading text-center col-12 fade">
                <h2>Relocate right - Estate agency</h2>
                <p>We specialise in bringing the best offers on the market.</p>
                <p>So the only thing you have to think about is how to place the new furniture.
                    We would like to invite you to peruse our listings and if you find something you like give us a call.
                </p>
            </div>
        </div>
        <div class="row">
                <p id="session_message">
                <?php
                if(! isset($_SESSION['user_id']) ) {
                    echo ('Please login below to view all our listings:');
                } else {
                    echo $_SESSION['message'];
                }
                ?>
                </p>
            <?php

                if(!isset($_SESSION['user_id']) ) {
                    require('users/login.php');
                    require('users/register.php');
                }
            ?>
        </div>
    </div>
</div>


