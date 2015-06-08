<?php
$hostname_conn = "localhost";
$database_conn = "evelotteries_";
$username_conn = "evelotteries_";
$password_conn = "QPsU2fQNTnmTY6Lq";
$conn = mysql_connect($hostname_conn, $username_conn, $password_conn) or die(mysql_error());

mysql_select_db($database_conn) or die(mysql_error());



function IM_DATAS($query='')
{
    $retVal = array();
    if(mysql_real_escape_string($query)){
        $query = mysql_query($query);
        while($data = mysql_fetch_assoc($query))
        {
            $retVal[] = $data;
        }
    }
    return $retVal;
}

function date2time($date)
{
    $annee = substr($date,0,4);
    $mois = substr($date,5,2);
    $jour = substr($date,8,2);
    $heures = substr($date,11,2);
    $minutes = substr($date,14,2);
    $secondes = substr($date,17,2);
    return mktime($heures,$minutes,$secondes,$mois,$jour,$annee);
}

$listing = IM_DATAS("SELECT * FROM `statistics` WHERE `type` LIKE '%credit%'  ORDER BY `statistics`.`created`  DESC LIMIT 2000");
echo '<table>';
for($cpt=0;$cpt<count($listing);$cpt++)
{
    $diff = date2time($listing[$cpt]['created'])-date2time($listing[$cpt+1]['created']);

    if($diff < 45 && $listing[$cpt]['user_id'] == $listing[$cpt+1]['user_id'] && $listing[$cpt]['isk_value'] == $listing[$cpt+1]['isk_value'] && $listing[$cpt]['eve_item_id'] == $listing[$cpt+1]['eve_item_id'])
    {
        $color = 'red';
    }
    else
    {
        if($color=="red" && $listing[$cpt]['user_id'] == $listing[$cpt-1]['user_id'] && $listing[$cpt]['eve_item_id'] == $listing[$cpt-1]['eve_item_id'] && $listing[$cpt]['isk_value'] == $listing[$cpt-1]['isk_value'] && $listing[$cpt]['eve_item_id'] == $listing[$cpt-1]['eve_item_id'])
            $color = 'red';
        else
            $color = 'bkack';
    }
    if($color=='red')
    {
        $user = IM_DATAS("SELECT eve_name FROM `users` WHERE id = '".$listing[$cpt]['user_id']."'");
        echo '<tr style="color:'.$color.'">';
        echo '<td>'.$listing[$cpt]['user_id'].'-'.$user[0]['eve_name'].'</td>';
        echo '<td>'.$listing[$cpt]['type'].'</td>';
        echo '<td>'.$listing[$cpt]['value'].'</td>';
        echo '<td>'.number_format($listing[$cpt]['isk_value']).'</td>';
        echo '<td>'.$listing[$cpt]['eve_item_id'].'</td>';
        echo '<td>'.$listing[$cpt]['created'].'</td>';
        echo '</tr>';
    }
}
echo '</table>';
?>


