<?php 

namespace Rencie\Cpm;

use Rencie\Cpm\CpmActivity;

class Cpm {

	private $activities = array();
	private $na;

	public  function __construct($activities) {
		$this->activities = $activities;
		$this->activities = $this->GetActivities($this->activities);
		$this->activities = $this->WalkListAhead($this->activities);
		$this->activities = $this->WalkListAback($this->activities);

		// echo '<pre>';
		// print_r($this->activities);
		// echo '</pre>';
	}
	/**
	 * Get all Activities
	 */
	private function GetActivities($activities){
		$this->na = count($activities);

		// get successor
		foreach ($activities as $activity) {
			$np = count($activity->predecessors);
			if($np > 0){
				$_successor = array();

				for($j = 0; $j < $np; $j++){
					$activities[CpmActivity::GetIndex($activities, $activity->predecessors[$j],$this->na)]->successors[] = $activity->id;
				}
			}
			
		}

		return $activities;
	}

	private function WalkListAhead($activities)
	{

		$activities[0]->eet = $activities[0]->est + $activities[0]->duration;

		for($i = 1; $i < $this->na; $i++)
		{
			$np = count($activities[$i]->predecessors);
			if($np > 0){
				foreach($activities[$i]->predecessors as $row)
				{
					$activity = CpmActivity::CheckActivity($activities,$row,$this->na);
					if($activities[$i]->est < $activity->eet){
						$activities[$i]->est = $activity->eet;
					}
				}
			}
			

			$activities[$i]->eet = $activities[$i]->est + $activities[$i]->duration;
		}

		return $activities;
	}


	private function WalkListAback($activities)
	{
		$activities[$this->na - 1]->let = $activities[$this->na - 1]->eet;
		$activities[$this->na - 1]->lst = $activities[$this->na - 1]->let - $activities[$this->na - 1]->duration;

		for($i = $this->na - 2; $i >= 0; $i--)
		{
			if(!empty($activities[$i]->successors)){
				foreach($activities[$i]->successors as $row)
				{
					$activity = CpmActivity::CheckActivity($activities,$row,$this->na);
					if($activities[$i]->let == 0){

						$activities[$i]->let = $activity->lst;
					}	
					else{
						if($activities[$i]->let > $activity->lst){
							$activities[$i]->let = $activity->lst;
						}
						
					}
					
				}
			}
			

			$activities[$i]->lst = $activities[$i]->let - $activities[$i]->duration;
		}

	  return $activities;
	}

	public function CriticalPath(){
		$path = "";
		foreach($this->activities as $activity)
		{
			if(($activity->eet - $activity->let == 0) && ($activity->est - $activity->lst == 0)){
				$path .= $activity->task_id ." -> ";
			}
		}
		return substr($path, 0, -4);
	}

	public function TotalDuration(){
		return $this->activities[count($this->activities) - 1]->eet;
	}
}