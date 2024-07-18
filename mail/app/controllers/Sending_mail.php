<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sending_mail extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('approvals');
    }
    public function index()
    {}
    public function send($offersheet)
    {
        $pending=$this->approvals->sending_mail($offersheet);

        if($pending)
        {
            foreach($pending as $pend)
            {
                
                $items=$this->approvals->show_item_send($pend['auc_id'],$pend['bidder_id'],$pend['auc_start_time'],$pend['auc_end_time']);
                if($items)
                {
                    $data['offersheet']=$pend;
                    $products=array();
                    foreach($items as $item)
                    {
                        $product=array();
                        $product['lot_no']=$item['lot_no'];
                        $product['garden_nm']=$item['garden_nm'];
                        $product['grade']=$item['grade'];
                        $product['invoice_no']=$item['invoice_no'];
                        $product['pkgs']=$item['pkgs'];
                        $product['valu_kg']=$item['valu_kg'];
                        $product['bid_price']=$item['bid_price'];
                        
                        array_push($products,$product);
                    }
                    $data['items']=$products;
                    $message=$this->load->view('appoval-letter',$data,true);
                    $this->load->library('email'); // Note: no $config param needed
                    $this->email->from('admin@andrewyule.in', 'Private Sale');
                   // $this->email->to($pend['email_id']);
                    $this->email->to('surajit@infotechsystems.in');
                    $this->email->subject('Offersheet No: '.$pend['offer_srl']);
                    $this->email->message($message);
                    $res_email=$this->email->send();
                    if($res_email==true):
                      $data=array(
                        'auc_status'=>'M',
                        'mail_send'=>'Y'
                      );
                    $res = $this->approvals->update_data($data,$pend['auc_id'],$pend['bidder_id'],$pend['auc_start_time'],$pend['auc_end_time']);	
                    endif;
                }
            }
        }
	}

}
?>
