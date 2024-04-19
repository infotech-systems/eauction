<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
?>
<?php
if(($tag=="CHANGEUSER"))
{
    $user_name= isset($_POST['user_name'])? $_POST['user_name']: '';
 
    $sql=" select uid,user_type from user_mas  ";
    $sql.="  where user_id=:user_name ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':user_name', $user_name);
    $sth->execute();
    $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $sth->fetch();
    $user_type=$row2['user_type'];
    $uid=$row2['uid'];
    if($user_type!='B')
    {
        ?>
        <input type="hidden" name="bidder" id="bidder">
        <?php
    }
    else
    {
        ?>
        <select class="form-control select2" name="bidder"  id="bidder">
            <?php
            $sqle= "select bidder_id,billing_nm ";
            $sqle.="from bidder_mas where uid=:uid order by billing_nm ";
            $sth = $conn->prepare($sqle);
            $sth->bindParam(':uid', $uid);
            $sth->execute();
            $ss=$sth->setFetchMode(PDO::FETCH_ASSOC);
            $row = $sth->fetchAll();
            foreach ($row as $key => $value) 
            {
                $bidder_id=$value['bidder_id'];
                $billing_nm=$value['billing_nm'];
                ?>
                <option value="<?php echo $bidder_id; ?>"><?php echo $billing_nm; ?></option>
                <?php
            }
            ?>
        </select>
        <script>
            $(".select2").select2();
    <?php
    }
    
}
?>

<?php
$conn=null;
?>