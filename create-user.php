<?php
    if (R::count('steamuser', "steam = ?", array($_SESSION['steamid'])) == 0) {
        $steamuser = R::dispense('steamuser');
        $steamuser->steam = $steamprofile['steamid'];
        $steamuser->username = $steamprofile['personaname'];
        $steamuser->regdate = R::isoDate();
        R::store($steamuser);
    } ?>