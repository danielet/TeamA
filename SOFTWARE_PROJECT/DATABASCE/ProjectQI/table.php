<?
include ("./include.php");
echo"
<div class='container content'>
<div class='row'>
<div>
<div class='row'>
<!--Hover Rows-->
<div>
    <div class='panel panel-yellow margin-bottom-40'>
        <div class='panel-heading'>
            <h3 class='panel-title'><i class='fa fa-gear'></i>USER INFORMATION [SAMPLE]</h3>
        </div>
        <table class='table table-hover'>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>FIRSTNAME</th>
                    <th>LASTNAME</th>
                    <th>ID</th>
                    <th>SALTVALUE</th>
                    <th>SALTPASS</th>
                    <th>LOGINCNT</th>
                </tr>
            </thead>
            <tbody>
                <tr>"
                ?>
                <?php
                    $query = "select * from USER";
                    $result = mysqli_query($DB, $query);
                    //$chk_data = mysqli_fetch_array($result);
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                        echo"<tr>";
                        echo"<td>$i</td>";
                        echo"<td>$row[U_FIRSTNAME]</td>";
                        echo"<td>$row[U_LASTNAME]</td>";
                        echo"<td>$row[U_ID]</td>";
                        echo"<td>$row[U_SALTVALUE]</td>";
                        echo"<td>$row[U_SALTPASS]</td>";
                        echo"<td>$row[LOGINCNT]</td>";
                        echo"</tr>";
                        $i++;
                    }
                
                    /* free result set */
                    $result->close();
                    /*while($row = $chk_data->fetch_assoc ()) {
                    
                    }*/
                ?><?echo"
            </tbody>
        </table>
    </div></div></div></div></div></div>
</div>"
?>
<!--End Hover Rows-->