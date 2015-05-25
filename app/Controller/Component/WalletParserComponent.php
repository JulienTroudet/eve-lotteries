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
}