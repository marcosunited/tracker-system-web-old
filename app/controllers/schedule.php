<?
		$schedule = new schedule();
		class schedule{
			function index()
			{
				$id = req('frm_job_id');
				$query = "select * from schedule
							inner join lifts on schedule.lift_id = lifts.lift_id
							inner join _service_areas on schedule.service_area_id = _service_areas.service_area_id
							inner join _service_types on schedule.service_type_id = _service_types.service_type_id
							inner join _frequency on schedule.frequency_id = _frequency.frequency_id
							where lifts.job_id = $id";
							
				$data = array(
					"result" => query($query)
				);			
				view_plain("schedule/schedule_table",$data);	
			}
			function form()
			{
				$values = _getValues("schedule","schedule_id");
				$job_id = req('frm_job_id');
				$lifts = get_query("select * from lifts where job_id = $job_id and status_id = 1");
				
				$values["last_completed"] = toDate($values["last_completed"]);
				$data = array(
					"values" => $values,
					"job_id" => $job_id,
					"lifts" => $lifts
				);		
				
				view_plain("schedule/schedule_form",$data);                                            
			}
			function action()
			{
				$url = app('url');
				$job_id = req('job_id'); //no frm_ on this one as its not in the table were submitting to. just easy and lazy!
				
				req('frm_last_completed',strtotime(req('frm_last_completed')));
				$alert = _submitForm("schedule","schedule_id");
				
				if(req("frm_schedule_id")){ 
					redirect("$url/exec/schedule/form/?alert=$alert&frm_schedule_id=".req("frm_schedule_id")."&frm_job_id=$job_id");
				}else{
					redirect("$url/exec/schedule/?alert=$alert&frm_job_id=$job_id");
				}
			}
			function delete()
			{
				$id = req('frm_schedule_id');
				$job_id = req('frm_job_id');
				
				$query = "delete from schedule where schedule_id = $id";
				query($query);
				redirect(app('url')."/exec/schedule/?frm_job_id=$job_id");
			}
		}
?>