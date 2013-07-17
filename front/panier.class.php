<?php

class panier{

	private $DB;

	public function __construct($DB){
		if(!isset($_SESSION)){
			session_start();
		}
		if (!isset($_SESSION['panier'])){
			$_SESSION['panier'] = array();
		}
		$this->DB =$DB;

		if(isset($_GET['delPanier']))
		{
			$this->del($_GET['delPanier']);
		}
		
	}

	public function count(){
		return array_sum($_SESSION['panier']);
	}

	public function total(){

		$total = 0;
		$variable =array_keys($_SESSION['panier']);
		if (empty($variable)) {
			$objets = array();
		}else{
		$objets = $this->DB->query('select * from museotouch.objets WHERE objets_id IN('.implode(',',$variable).')');
		}
		foreach ($objets as $objet) {	
			$total += $objet->price * $_SESSION['panier'][$objet->objets_id];
		}
		return $total;
	}

	public function add($objet_id){
		if(isset($_SESSION['panier'][$objet_id])){
			$_SESSION['panier'][$objet_id]++;
		}else{
			$_SESSION ['panier'][$objet_id] = 1;
		}
		
	}

	public function del($objet_id){
		unset($_SESSION ['panier'][$objet_id]);
	}

}