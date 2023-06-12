<?php 
header("X-XSS-Protection: 1;mode = block");
include('./header.php'); ?>
<?php
$mitem = isset($_POST['mitem']) ? $_POST['mitem'] : '';
$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
$hr_id = isset($_REQUEST['hr_id']) ? $_REQUEST['hr_id'] : '';
$hid_hr_id = isset($_POST['hid_hr_id']) ? $_POST['hid_hr_id'] : '';

$block_nm="";
$sql=" select um.uid,um.user_name,um.page_assign ";
$sql.=" from user_mas um ";
$sql.=" where uid=:hr_id  ";
$sth = $conn->prepare($sql);
$sth->bindParam(':hr_id', $hr_id);
$sth->execute();
$row = $sth->fetch();
$uid=$row['uid'];
$user_name=$row['user_name'];
$page_par_temp=$row['page_assign'];
$page_pars_temp=explode(",",$page_par_temp);

//echo "sss $page_par_temp";
if($submit=="Submit")
{
	$str_menu_id='';
	for($i=0;$i<=count($mitem)-1;$i++)
	{ 
		$str_menu_id.= $mitem[$i].",";
	}
	$str_menu_id.="0";
	$sql =" update user_mas set page_assign=trim(:str_menu_id) ";
	$sql.=" where  ";
	$sql.=" uid=:hr_id ";
//echo "$sql--$str_menu_id--$hr_id";
	$sth = $conn->prepare($sql);
	$sth->bindParam(':str_menu_id', $str_menu_id);
	$sth->bindParam(':hr_id', $hid_hr_id);
	$sth->execute();

	?>
	<script language=javascript>
    alertify.success('Page Permission Successfully');
    window.location.href='./user-mas.php';
    </script>
    <?php
} 
if(!empty($hr_id)) 
{
?>
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Page Permission for <?php echo $user_name; ?>  <?php echo $block_nm; ?>  </h3>
              </div>
            <!-- /.box-header -->
            <form name="form1" method="post" enctype="multipart/form-data" onSubmit="return validate()">

            <div class="box-body table-responsive no-padding">
            
            <table  class="table table-hover">
            <tr>
            <th>Main Menu</th>
            <th>Sub Menu</th>
            <th colspan="3">Menu</th>
            </tr>
            <?php
            $sql ="select * from menu_mas where parent_id='0' ";
            //$sql.="and show_tag='T' ";
            $sql.="order by menu_id";
            $sth = $conn->prepare($sql);
            $sth->execute();
            $row = $sth->fetchAll();
            foreach ($row as $key => $value)
            { 
              $mbody=$value['mbody'];
              $menu_id=$value['menu_id'];
              for($l=0;$l<count($page_pars_temp); $l++)
              {
              if ($page_pars_temp[$l]==$menu_id) 
              {
              $flag="checked";
              break;
              }
              else
              $flag="";
              }
            ?>
            <tr> 
            <td colspan="5"><?php echo "<input type='CHECKBOX' name='mitem[]' value='$menu_id' $flag >&nbsp;&nbsp;$mbody"; ?></td></tr>
            
            <?php
            $sql1="select * from menu_mas where parent_id=:menu_id ";
			//$sql1.="and show_tag='T' ";
			$sql1.="order by menu_id";
            $sth1 = $conn->prepare($sql1);
			$sth1->bindParam(':menu_id', $menu_id);
			$sth1->execute();
			$row1 = $sth1->fetchAll();
			foreach ($row1 as $key1 => $value1)
			{ 
				$mbody1=$value1['mbody'];
				$menu_id1=$value1['menu_id'];
            ?>
            <tr><td></td>
            <td> 
            <?php
            for($l=0;$l<count($page_pars_temp); $l++)
            {
            if ($page_pars_temp[$l]==$menu_id1) 
            {
            $flag="checked";
            break;
            }
            else
            $flag="";
            }
            $sql2 ="select count(*) as totm ";
			$sql2.="from menu_mas where menu_id=:menu_id and show_tag='T'   ";
            $sth2 = $conn->prepare($sql2);
			$sth2->bindParam(':menu_id', $menu_id);
			$sth2->execute();
			$row2 = $sth2->fetch();
            $tot2=$row2['totm'];
            if($tot2>0) echo "<input type='CHECKBOX' name='mitem[]' value='$menu_id1' $flag >&nbsp;&nbsp;$mbody1";
            else echo "&nbsp;$mbody1";
            echo  "</td>";
            $sql3="select * ";
			$sql3.="from menu_mas where parent_id=:menu_id1 and show_tag='F' order by menu_id";
             $sth3 = $conn->prepare($sql3);
			 $sth3->bindParam(':menu_id1', $menu_id1);
			 $sth3->execute();
			 $row3 = $sth3->fetchAll();
             $tot3=count($row3);
            if($tot3 >0)
            echo "<td></td>";
            echo "<td colspan='3'><font color='#0000FF'><b>&nbsp;";
            foreach ($row3 as $key3 => $value3) 
			{
            	$mbody3=$value3['mbody'];
            	$menu_idch3=$value3['menu_id'];
            for($l=0;$l<count($page_pars_temp); $l++)
            {
            if ($page_pars_temp[$l]==$menu_idch3)
            {
            $flag="checked";
            break;
            }
            else
            $flag="";
            }
            
            echo "<input type='CHECKBOX' name='mitem[]' value='$menu_idch3' $flag >&nbsp;".$mbody3."&nbsp;";
            
            }
            if($tot3 >0)
            echo "&nbsp;&nbsp;</b></font>";
            echo "</td>
            </tr>";
            
            }
            
            
            ?>
            
            
            <?php  
            }
            ?>
            </table>
              
            </div>
            <!-- /.box-body -->
             <div class="box-footer">
                
                <input type="submit" name="submit" id="submit" class="btn btn-primary pull-right" value="Submit">
              </div>
              <input type="hidden" name="hid_hr_id" value="<?php echo $hr_id;?>" />
           </form>
          </div>
          <!-- /.box -->
        </div>
      </div>   
 <?php
 }
 ?>        
<?php include('./footer.php'); ?>     
