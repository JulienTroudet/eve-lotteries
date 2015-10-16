<?php

App::uses('Component', 'Controller');
class WalletParserComponent extends Component {

	/**
	 * Parse the line copied from the corporation wallet, when a player does a deposit
	 * @param  [type] $stringDeposit [description]
	 * @return [type]                [description]
	 */
    public function parseOneDeposit($stringDeposit) {
        
    	//2015.05.17 17:40:43	Player Donation	40 000 000 ISK	8 544 735 489 ISK	cbk-1 deposited cash into EVE-Lotteries Corporation's account
        
    	$delimiter = "\t";
		$splitcontents = explode($delimiter, $stringDeposit);

		if( sizeof($splitcontents) != 5){
			return false;
		}

		$deposit = array();

		$deposit["date"] = $splitcontents[0];
		$deposit["type"] = $splitcontents[1];
		$deposit["amount"] = str_replace(" ISK","", $splitcontents[2]);
		//careful here as we replace a special character, not a conventional space
		$deposit["amount"] = str_replace(" ","", $deposit["amount"]);
		$deposit["amount"] = str_replace(" ","", $deposit["amount"]);
		$deposit["amount"] = str_replace(".","", $deposit["amount"]);
		$deposit["amount"] = str_replace(",",".", $deposit["amount"]);
		$deposit["amount"] = round($deposit["amount"], 2);

		$deposit["userName"] = str_replace("[r] ", "", $splitcontents[4]);
		$deposit["userName"] = str_replace(" deposited cash into EVE-Lotteries Corporation's account", "", $deposit["userName"]);
		
		if($deposit["type"] == "Player Donation"){
			return $deposit;
		}

        return false;
    }

    /**
     * This function parses a line copied from the ingame wallet or contract panel
     * @param $inGameString
     * @param $typeOfWithdrawal
     * @return array|bool
     */
    public function parseOneWithdrawal($inGameString, $typeOfWithdrawal) {

        $delimiter = "\t";
        $splitContents = explode($delimiter, $inGameString);
        $deposit = array();

        if($typeOfWithdrawal == 'award_isk'){
            //2015.09.26 13:35:38	Corporation Account Withdrawal	-18 846 294,00 ISK	16 443 412 761,03 ISK	[r] Natasha Tolsen transferred cash from EVE-Lotteries Corporation's corporate account to Annecha Trouille's account
            if( sizeof($splitContents) != 5){
                return false;
            }
            $deposit["date"] = $splitContents[0];
            $deposit["type"] = $splitContents[1];
            $deposit["amount"] = str_replace(" ISK","", $splitContents[2]);
            //careful here as we replace a special character, not a conventional space
            $deposit["amount"] = str_replace(" ","", $deposit["amount"]);
            $deposit["amount"] = str_replace(" ","", $deposit["amount"]);
            $deposit["amount"] = str_replace(".","", $deposit["amount"]);
            $deposit["amount"] = str_replace(",",".", $deposit["amount"]);
            $deposit["amount"] = round($deposit["amount"], 2);

            $userNames = str_replace("[r] ", "", $splitContents[4]);
            $userNames = str_replace(" transferred cash from EVE-Lotteries Corporation's corporate account to ", "\t", $userNames);
            $userNames = explode($delimiter, $userNames);

            $deposit["givenBy"] = $userNames[0];
            $deposit["userName"] = str_replace("'s account", "", $userNames[1]);

            if($deposit["type"] == "Corporation Account Withdrawal"){
                return $deposit;
            }
        }
        else if($typeOfWithdrawal == 'award_item'){
            //Astero	Item Exchange	EVE-Lotteries Corporation	Veritas Shinu	Finished	2015.09.23 07:47

            if( sizeof($splitContents) != 7){
                return false;
            }

            $deposit["name"] = $splitContents[0];
            $deposit["type"] = $splitContents[1];
            $deposit["issuer"] = $splitContents[2];

            $deposit["userName"] = $splitContents[3];

            $deposit["status"] = $splitContents[4];

            $deposit["date"] = $splitContents[5];



            if($deposit["type"] == "Item Exchange"){
                return $deposit;
            }
        }
        return false;
    }

    /**
     * This function parses a line copied from the ingame wallet or contract panel
     * @param $inGameString
     * @param $typeOfWithdrawal
     * @return array|bool
     */
    public function parseOneWage($inGameString) {

        $delimiter = "\t";
        $splitContents = explode($delimiter, $inGameString);
        $deposit = array();

            //2015.09.26 13:35:38	Corporation Account Withdrawal	-18 846 294,00 ISK	16 443 412 761,03 ISK	[r] Natasha Tolsen transferred cash from EVE-Lotteries Corporation's corporate account to Annecha Trouille's account
            if( sizeof($splitContents) != 5){
                return false;
            }
            $deposit["date"] = $splitContents[0];
            $deposit["type"] = $splitContents[1];
            $deposit["amount"] = str_replace(" ISK","", $splitContents[2]);
            //careful here as we replace a special character, not a conventional space
            $deposit["amount"] = str_replace(" ","", $deposit["amount"]);
            $deposit["amount"] = str_replace(" ","", $deposit["amount"]);
            $deposit["amount"] = str_replace(".","", $deposit["amount"]);
            $deposit["amount"] = str_replace(",",".", $deposit["amount"]);
            $deposit["amount"] = round($deposit["amount"], 2);

            $userNames = str_replace("[r] ", "", $splitContents[4]);
            $userNames = str_replace(" transferred cash from EVE-Lotteries Corporation's corporate account to ", "\t", $userNames);
            $userNames = explode($delimiter, $userNames);

            $deposit["givenBy"] = $userNames[0];
            $deposit["userName"] = str_replace("'s account", "", $userNames[1]);

            if($deposit["type"] == "Corporation Account Withdrawal"){
                return $deposit;
            }

        return false;
    }
}