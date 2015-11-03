<?php namespace App\Repositories;
use  App\Utilities\Utility;

abstract class BaseRepository {

	/**
	 * The Model instance.
	 *
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;
	protected $Utility;

	/**
	 * Get number of records.
	 *
	 * @return array
	 */
	public function getNumber()
	{
		$total = $this->model->count();
		$new = $this->model->whereSeen(0)->count();
		return compact('total', 'new');
	}
	/**
	 * Get record by id.
	 *
	 * @return records
	 */	
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}
	/**
	 * add hijri shamsi date to records.
	 *
	 */	
	protected function AddJalaliDate($Res,$token=" ",$Array=true)
	{
		if ($Array)
			foreach ($Res as $TmpRec)
			{
				$t=$this->Utility->get_jalali_date($TmpRec->created_at);
				$TmpRec->JalaliCreate_at = $t['jyear'].$token.$t['jmonth'].$token.$t['jday'];
				$TmpRec->JalaliCreateTime = $t['jtime'];
				
				$t=$this->Utility->get_jalali_date($TmpRec->updated_at);
				$TmpRec->JalaliUpdated_at = $t['jyear'].$token.$t['jmonth'].$token.$t['jday'];
				$TmpRec->JalaliUpdatedTime = $t['jtime'];				
				
			}
		else
		{
			$t=$this->Utility->get_jalali_date($Res->created_at);
			$Res->JalaliCreate_at = $t['jyear'].$token.$t['jmonth'].$token.$t['jday'];
			$Res->JalaliCreateTime = $t['jtime'];
			
			$t=$this->Utility->get_jalali_date($Res->updated_at);
			$Res->JalaliUpdated_at = $t['jyear'].$token.$t['jmonth'].$token.$t['jday'];
			$Res->JalaliUpdatedTime = $t['jtime'];			
		}
	}
}
?>