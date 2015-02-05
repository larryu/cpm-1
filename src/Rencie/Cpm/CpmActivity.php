<?php 

namespace Rencie\Cpm;


class CpmActivity {

	public $id;
	public $description;
	public $duration;
	public $est = 0;
	public $lst = 0;
	public $eet = 0;
	public $let = 0;
	public $successors;
	public $predecessors;
	
	public static function CheckActivity($activities, $id, $i)
	{
		for($j = 0; $j < $i; $j++)
		{
			if($activities[$j]->id == $id)
			return $activities[$j];
		}
		return null;
	}

	public static function GetIndex($activities, $activity_id, $i)
	{
		for($j = 1; $j < $i; $j++)
		{
			if($activities[$j]->id == $activity_id){
				return $j;
			}
		}
		return 0;
	}
	
}