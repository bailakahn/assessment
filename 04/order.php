<?php

	include 'taxes.inc';
	include 'coupon.inc';

class Order {

	private $coupon;
	private $total;
	private $user;

	/**
     * Order constructor.
     * @param $user User the user who completed the order
     * @param $total float the order total
     * @param $coupon string the user coupon
     */
	function __construct(User $user, $total, $coupon = null){

		$this->user = $user;

		$this->total = $total;

		if (!is_null($coupon)) {
			
			$this->coupon = $coupon;

		}

	}


	/**
	* @return float the order total 
	*/
	public function getTotal(){

		return $this->total;
	
	}

	/**
	* @return string the order coupon 
	*/
	public function getCoupon(){

		return $this->coupon;
	
	}

	/**
	* @return float the order new total 
	*/
	public function applyDiscount(){

		include 'coupon.inc';

		if (!is_null($this->coupon)) {

			foreach ($coupons as $coupon) {
			
				if ($coupon['id'] === $this->coupon) {

					$this->total = $this->total - ($this->total * $coupon['discount']);

				}

			}
		}

		return $this->total;

	}

/*
	public function calculTaxes($total, $tps, $tvq = null){

		if (is_null($tvq)) {

			$total = $total + ($total * $tps);

		}else{
			
			$total = $total + ($total * $tps) + ($total * $tvq);

		}

		return $total;
	}
*/

	/**
	* @return float the order final total
	*/
	public function chargeTaxes(){

		include 'taxes.inc';

		$user_province = $this->user->getProvince();

		//apply discount
		$this->applyDiscount();

		switch ($user_province) {

			case 'on':

				$this->total = $this->total + ($this->total * $tax['on'][0]);

				break;
			
			case 'qc':

				$this->total = $this->total + ($this->total * $tax['qc'][0]) + ($this->total * $tax['qc'][1]);

				break;

			default:

				die('Something bad hapenned');

				break;

		}

		return $this->total;

	}


}
