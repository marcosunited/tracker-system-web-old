<?php
    $tasks = new tasks();
    class tasks{
        function index()
        {
            $data = array(
                "result" => query("SELECT 
                        *
                        FROM _tasks 
						inner join _service_areas on _tasks.service_area_id = _service_areas.service_area_id
						inner join _service_types on _tasks.service_type_id = _service_types.service_type_id
                    ")
            );			
            view("tasks/tasks_table",$data);
        }
        
        function form()
        {
            $values = _getValues("_tasks","task_id");
            $data = array(
                "values" => $values
            );			
            view("tasks/tasks_form",$data);                                            
        }
        
        function action()
        {
                $url = app('url');
                $alert = _submitForm("_tasks","task_id");
                if(req("frm_task_id")){ 	//if an id was specified, we must have done an update.
                    redirect("$url/exec/tasks/form/?alert=$alert&frm_task_id=".req("frm_task_id"));
                }else{ 	//no field id? then it must be a new record
                    redirect("$url/exec/tasks/?alert=$alert");
                }
        }
        
        function delete()
        {
            $id = req('frm_task_id');
            $query = "delete from _tasks where task_id = $id";
            query($query);
            redirect(app('url')."/exec/tasks/");
        }
    }
?>