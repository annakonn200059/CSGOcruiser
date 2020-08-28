<html lang="en">
<link rel="stylesheet" href="css/style.css">
<?php require_once "db.php";
require_once "steamauth/userInfo.php";
/*require_once "steamauth/steamauth.php";*/
?>
<body>
<?php if((isset($_SESSION['steamid']))) :?>
    <?php if (R::count('steamuser', "steam = ?", array($_SESSION['steamid'])) == 0) {
        $steamuser = R::dispense('steamuser');
        $steamuser->steam = $steamprofile['steamid'];
        $steamuser->username = $steamprofile['personaname'];
        $steamuser->regdate = R::isoDate();
        R::store($steamuser);
    } 
    echo "<img src =\"$steamprofile[avatarmedium]\">"; //avatar
    $user = R::findOne('steamuser', "steam = ?", array($_SESSION['steamid']));
    if (!isset($user->tradelink)) {
        echo "Введите ссылку на обмен в профиле!";
    }
    ?>
<?php endif; ?>

<?php
 require_once "db.php";
 require_once "steamauth/userInfo.php";
 echo "<img src =\"$steamprofile[avatarmedium]\"> <br>";
 echo $steamprofile['personaname'];
 $id = parse_url($steamprofile['profileurl'])['path'];
 $cur = R::findOne('steamuser', "steam = ?", array($_SESSION['steamid']));
 $url = "https://steamcommunity.com"."$id"."/tradeoffers/privacy#trade_offer_access_url";
?>
    
<div class="link_line">
    <a><?php echo'<a href="'.$url.'" target=_\'blank\'>'.'Где взять ссылку?'.'</a>'; ?></a>
</div>

<div class="header__logo__block">
    <form action="/profile.php" method="post">
        <p>
            <input type="text" name="tradelink" value="<?php echo $cur->tradelink; ?>"> </input>
        </p>
        <p>
            <button type="submit" name="trade_submit">Готово</button>
        </p>
    </form>
</div>
<?php
    $data = $_POST;
    if(isset($data['trade_submit'])){
        require_once "tradevalidate.php";
        if ($link) {
            echo 'Ссылка обмена неверная!';
        }
        else {
            $user = R::findOne('steamuser', "steam = ?", array($_SESSION['steamid']));
            $user->tradelink = $data['tradelink'];
            R::store($user);
            echo "Готово!";
        }
    }
    
?>

<div class="line">
    <div class="header__logo__block">
        <a href="/steamauth/main_page.php">
            <img src="images/logo.png" alt="Logo">
        </a>
    </div>
                        
    <div class="link_line">
        <ul class="main_links">
            <li>
                <a href="/index.html">На главную</a>
            </li>
            <li>
                <a href="/steamauth/logout.php">Выйти из Steam</a> 
            </li>
        </ul>
    </div>
</div>
</body>
</html>