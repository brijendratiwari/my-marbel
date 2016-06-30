<?php
class Calendar_model extends CI_Model {
    
    function calendar_process(){
            $table='m_calendar';
            $type = $this->input->post('type');

            if($type == 'new')
            {
                    $startdate = $this->input->post('startdate').'+'.$this->input->post('zone');
                    $title = $this->input->post('title');
                    $new=array('title'=>$title,'startdate'=>$startdate,'enddate'=>$startdate,'allDay'=>'false');
                    $this->db->insert($table,$new);
                  
                    $lastid = $this->db->insert_id();
                    echo json_encode(array('status'=>'success','eventid'=>$lastid));
            }

            if($type == 'changetitle')
            {
                    $eventid = $this->input->post('eventid');
                    $title = $this->input->post('title');
                    $changetitle=array('title'=>$title);
                    $this->db->where('id',$eventid);
                    $this->db->update($table,$changetitle);
                    $afftectedRows = $this->db->affected_rows();
                    if($afftectedRows)
                            echo json_encode(array('status'=>'success'));
                    else
                            echo json_encode(array('status'=>'failed'));
            }

            if($type == 'resetdate')
            {
                    $title = $this->input->post('title');
                    $startdate = $this->input->post('start');
                    $enddate = $this->input->post('end');
                    $eventid = $this->input->post('eventid');
                    $resetdate=array('title'=>$title,'startdate'=>$startdate,'enddate'=>$enddate);
                    $this->db->where('id',$eventid);
                    $this->db->update($table,$resetdate);
                    $afftectedRows = $this->db->affected_rows();
                    if($afftectedRows)
                            echo json_encode(array('status'=>'success'));
                    else
                            echo json_encode(array('status'=>'failed'));
            }

            if($type == 'remove')
            {
                     $eventid = $this->input->post('eventid');
                     $this->db->where('id',$eventid);
                     $this->db->delete($table);
                     $afftectedRows = $this->db->affected_rows();
                    if($afftectedRows)
                            echo json_encode(array('status'=>'success'));
                    else
                            echo json_encode(array('status'=>'failed'));
            }

            if($type == 'fetch')
            {
                    $events = array();
                    $this->db->select('*')->from($table);
                    $query=$this->db->get();
                    if($query->num_rows()>0){
                       $getRecord=$query->result_array();
                       $i=0;
                       $get_final=array();
                       foreach($getRecord as $record){
                           $get_final[$i]['id']=$record['id'];
                           $get_final[$i]['title']=$record['title'];
                           $get_final[$i]['start']=$record['startdate'];
                           $get_final[$i]['end']=$record['enddate'];
                           $get_final[$i]['allDay']=($record['allDay']== "true") ? true : false;
                          $i++;
                       }
                       echo json_encode($get_final);
                    }else{
                        
                        echo json_encode(array('status'=>'failed'));
                    }
                   
                   
            }

        
    }
}