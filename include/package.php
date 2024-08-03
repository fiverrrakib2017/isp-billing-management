<?php
include "db_connect.php";
if(isset($_GET['list'])){


    
if ($package = $con -> query("SELECT * FROM radgroupcheck")) {
  
  
  while($rows= $package->fetch_array())
  {
	  $lstid = $rows["id"];
	  $groupname = $rows["groupname"];

	  $pool = $con->query("SELECT * FROM pool WHERE name='$groupname'");
			 while($rowp= $pool->fetch_array())
				  {
					 $pname = $rowp["name"];
					 $pstrtip = $rowp["ip_block"];
					 
				  }
	 echo '
	 <tr>
     <td>'.$rows["groupname"].'</td>
     <td>'.$pname.'</td>
     <td>'.$pstrtip.'</td>
     <td class="text-right">
        <a class="btn btn-info" href=""><i class="mdi mdi-border-color"></i></a>
        <a class="btn btn-success" href=""><i class="mdi mdi-eye"></i>
        </a>

        </td>
     </tr>
	 '; 
  }
  // Free result set
  //$result -> free_result();
}




}

if(isset($_GET['add']))
{
	echo $packgname = $_GET['package_name'];
	
	$con -> query("INSERT INTO radgroupcheck(groupname,attribute,op,value) VALUES('$packgname','Framed-Protocol','==','PPP')");

}

?>

<html>

<head>
    <script type="text/javascript">
    $(".lst_btn").on("click", function() {
        //alert("OK");
        var pacgkID = "pakgid=" + $(this).attr("id");
        //alert(idString);
        $(this).text(idString);

        $.ajax({
            type: "GET",
            url: "include/package_info.php?edit",

            data: pacgkID,
            dataType: "JSON",
            cache: false,
            success: function(pkginfo) {
                //alert(pkginfo.pckgname);			
                $("#packg_name").val(pkginfo.pckgname);
                $("#pckg-id").val(pkginfo.pckgid);
                $("#pool_name").prepend('<option select="selected" value=' + pkginfo.pckgid + '>' +
                    pkginfo.pckgname + '</option>');
            }
        });

        $("#btn_edit").trigger("click");
    });
    </script>

</head>

</html>