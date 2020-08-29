<?php require_once "db.php";
require_once "steamauth/userInfo.php";
/*require_once "steamauth/steamauth.php";*/
?>
<html lang="en">
<link rel="stylesheet" href="css/style.css">
<body>

<?php
//сделай чтобы красиво были ава там балансы и тд короче ниже помощь в 26 строке пример как сунут пхп в хтмл я пойду посмотрю про магазин люблю тебя
 require_once "steamauth/userInfo.php";
 echo "<img src =\"$steamprofile[avatarmedium]\"> <br>";
 echo $steamprofile['personaname'];
 $id = parse_url($steamprofile['profileurl'])['path'];
 $cur = R::findOne('steamuser', "steam = ?", array($_SESSION['steamid']));
 $url = "https://steamcommunity.com"."$id"."/tradeoffers/privacy#trade_offer_access_url";
?>
    
<div class="link_line">
    <a><?php echo'<a href="'.$url.'" target=_\'blank\'>'.'Click here for get your trade URL'.'</a>'; ?></a>
</div>

<div class="header__logo__block">
    <form action="/profile.php" method="post">
        <p>
            <input type="text" name="tradelink" value="<?php echo $cur->tradelink; ?>"> </input> 
        </p>
        <p>
            <button type="submit" name="trade_submit">Enter</button>
        </p>
    </form>
</div>
<?php
    $data = $_POST;
    if(isset($data['trade_submit'])){
        require_once "tradevalidate.php";
        if ($link) {
            echo 'Invalid link!';
        }
        else {
            $user = R::findOne('steamuser', "steam = ?", array($_SESSION['steamid']));
            $user->tradelink = $data['tradelink'];
            R::store($user);
            echo "Ok!";
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
                <a href="/steamauth/logout.php">Logout</a> 
            </li>
        </ul>
    </div>
</div>
</body>
</html>