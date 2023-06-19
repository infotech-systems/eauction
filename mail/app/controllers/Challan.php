<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Challan extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('challans');
    }
    public function index()
    {}
	 public function send($chl_id)
	 {
      $challan=$this->challans->show($chl_id);
      if($challan->mail_send=='N'):
        $data['orgn']=$this->challans->show_orgn($challan->orgn_id);

        $data['driver']=$this->challans->show_driver($challan->driver_id);
        if($challan->helper_id):
          $data['helper']=$this->challans->show_driver($challan->helper_id);
         else:
            $data['helper']=array();  
        endif;
        $data['challan']=$challan;
        $data['rental']=$this->challans->show_rental($challan->rental_type_id);
        $data['project']=$this->challans->show_proj($challan->proj_id);
        $items=$this->challans->show_items($challan->chl_no);
        $challans_dtl=array();
        if($items):
          $g=1;
          foreach($items as $item):
            $challans=array();
            $model_desc='';
            $challans['sl']=str_pad($g,2,0,STR_PAD_LEFT);
            if(!empty($model)):   $model_desc="[$model]"; endif;
            $challans['item_desc']=$item['item_desc'].''.$model_desc;
            $challans['item_qty']=$item['item_qty'];
            $acces=$this->challans->show_acces($challan->chl_no,$item['item_id']);
            if($acces):
              $i='a';
              $access=array();
              foreach($acces as $acc):
                $ac=array();
                  $ac['sl']=$i;
                  $ac['acc_desc']=$acc['acc_desc'];
                  $ac['item_qty']=$acc['item_qty'];
                  array_push($access,$ac);
              endforeach;
              $challans['details']=$access;

            else:
              $challans['details']=null;

            endif;
            array_push($challans_dtl,$challans);
            $g++;
          endforeach;
        endif;
        $data['challans']=$challans_dtl;
        $data['support']=$this->challans->show_support($challan->support_staff);
       // $this->load->view('challan',$data);

        $message=$this->load->view('challan',$data,true);
        $this->load->library('email'); // Note: no $config param needed
        $this->email->from('challan@eskaygroup.net', 'ESKAY GROUP');
      // $list = array('ashok.dhanuka@eskaygroup.in', 'tubandey2013@gmail.com','himanshu.dhanuka@eskaygroup.in','kashinath.006@gmail.com');

     //   $this->email->to('amitava.barat@gmail.com');
    //  $list=array('surajitmondal19@gmail.com');
        $this->email->cc($list);
       $this->email->to($challan->email_id);
        $this->email->subject('Challan No: '.$challan->chl_no);
        $this->email->message($message);
        $res_email=$this->email->send();
        if($res_email==true):
          $data=array(
            'mail_send'=>'Y'
          );
          $res = $this->challans->update_data($data,$chl_id);	
          if($res==true):
            echo '<script>alert("Mail send successully "); window.close();</script>';
          else:
            echo '<script>alert("Mail send failed "); window.close();</script>';
          endif;

        endif;
      
      else:
        echo '<script>alert("Mail already sent"); window.close();</script>';

      endif; 

	}

}
?>
