<?php
header("X-XSS-Protection: 1;mode = block");
include("../inc/dblib.inc.php");
$conn = OpenDB();
$tag = isset($_POST['tag']) ? $_POST['tag'] : '';
?>

<?php
if(($tag=='CHANGE-PLACE'))
{	
	$place=$_POST['place'];
    $sql=" select offer_srl ";
    $sql.=" from offer_srl_mas where offer_id=:place ";
    $sth = $conn->prepare($sql);
    $sth->bindParam(':place', $place);
    $sth->execute();
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $row = $sth->fetch();
    $e_offer_srl=$row['offer_srl'];

    $offer_srl_no='/'.date('Y').'/'.str_pad($e_offer_srl,4,"0",STR_PAD_LEFT);
    echo $offer_srl_no;
}

if(($tag=='AUCT-TYPE'))
{	
	$auct_type=$_POST['auct_type'];
    if($auct_type=='J')
    {
        ?>
        <div class="col-md-6">
            <div class="form-group  has-feedback">
                <label for="frequently" class="col-sm-4">Frequently</label>
                <div class="col-sm-8">
                    <input type="text" name="frequently" id="frequently" maxlength="3" class="form-control"  value=""  tabindex="8" >
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group  has-feedback">
                <label for="duration" class="col-sm-4">Duration (Minute)</label>
                <div class="col-sm-8">
                    <input type="text" name="duration" id="duration" maxlength="3" class="form-control"  value=""  tabindex="8" >
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<?php
$conn=null;
?>