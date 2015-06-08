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
$color='black';
$listing = IM_DATAS("SELECT * FROM  tickets WHERE id IN(SELECT ticket_id FROM `withdrawals` WHERE `status` = 'new')");
echo '<table>';
for($cpt=0;$cpt<count($listing);$cpt++)
{
    $lottery = IM_DATAS("SELECT * FROM lotteries WHERE id  = '".$listing[$cpt]['lottery_id']."'");

        $user = IM_DATAS("SELECT eve_name FROM `users` WHERE id = '".$listing[$cpt]['buyer_user_id']."'");
        echo '<tr style="color:'.$color.'">';
        echo '<td>'.$user[0]['eve_name'].'</td>';
        //echo '<td>'.$listing[$cpt]['type'].'</td>';
        echo '<td>'.$lottery[0]['name'].'</td>';
        echo '<td>'.$listing[$cpt]['modified'].'</td>';
        echo '</tr>';

}
echo '</table>';
?>


