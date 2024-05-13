<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Approval_mail extends SM_Controller
{
	function __construct()
	 {
	   parent::__construct();
	   $this->load->model('approvals');
    }
    public function index()
    {}
    public function send()
    {
        $pending=$this->approvals->pending_mail();

        if($pending)
        {
            foreach($pending as $pend)
            {
                
                $items=$this->approvals->show_item($pend['auc_id'],$pend['bidder_id'],$pend['auc_start_time'],$pend['auc_end_time']);
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
                        
                        $product['bid_price2']=$item['bid_price'];
                        $product['bid_price3']=$item['bid_price'];
                        $bid_price1=$this->approvals->show_bidprice($pend['auc_id'],$item['acd_id'],$item['bid_price']);
                        if($bid_price1)
                        {
                            $product['bid_price1']=$bid_price1->bid_price;

                            $bid_price2=$this->approvals->show_bidprice($pend['auc_id'],$item['acd_id'],$bid_price1->bid_price);
                            if($bid_price2)
                            {
                                $product['bid_price2']=$bid_price2->bid_price;

                                $bid_price3=$this->approvals->show_bidprice($pend['auc_id'],$item['acd_id'],$bid_price2->bid_price);
                                if($bid_price3)
                                {
                                    $product['bid_price3']=$bid_price3->bid_price;
                                }
                                else
                                {
                                    $product['bid_price3']=0;
                                }
                            }
                            else
                            {
                                $product['bid_price2']=0;
                                $product['bid_price3']=0;
                            }
                        }
                        else
                        {
                            $product['bid_price1']=0;
                            $product['bid_price2']=0;
                            $product['bid_price3']=0;
                        }
                        array_push($products,$product);
                    }
                    $data['items']=$products;
                    $data['signs']=$this->approvals->show_sign($pend['auc_id'],$pend['auc_start_time'],$pend['auc_end_time']);;
                    $message=$this->load->view('appoval-letter',$data);
                  /*  $this->load->library('email'); // Note: no $config param needed
                    $this->email->from('admin@andrewyule.in', 'Private Sale');
                    $this->email->to($pend['email_id']);
                    $this->email->subject('Offersheet No: '.$pend['offer_srl']);
                    $this->email->message($message);
                    $res_email=$this->email->send();
                    if($res_email==true):
                      $data=array(
                        'auc_status'=>'M',
                        'mail_send'=>'Y'
                      );
                    $res = $this->knockdowns->update_data($data,$pend['auc_id'],$pend['bidder_id'],$pend['auc_start_time'],$pend['auc_end_time']);	
                    endif;*/
                }
            }
        }
	}

}
?>
