<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once (APPPATH . 'third_party/Stripe/Stripe.php');

class Invoices extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoice_model', 'invoice');
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;
        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);
        $this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;

        $this->setting = Setting::find(1);
    }

    public function ajax_list()
    {
        $list = $this->invoice->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $invoice) {
            $no ++;
            $row = array();
            $row[] = sprintf("%05d", $invoice->id);
            $row[] = $invoice->clientname;
            $row[] = $invoice->tax;
            $row[] = $invoice->discount;
            $row[] = number_format((float)$invoice->total, $this->setting->decimals, '.', '');
            $row[] = $invoice->created_by;
            $row[] = $invoice->totalitems;

            switch ($invoice->status) {
                case 1: // case Credit Card
                    $satus = 'unpaid';
                    break;
                case 2: // case ckeck
                    $satus = 'Partiallypaid';
                    break;
                default:
                    $satus = 'paid';
            }
            $row[] = '<span class="' . $satus . '">' . label($satus) . '<span>';

            // add html for action
            if ($this->user->role === "admin")
                $row[] = '<div class="btn-group"><a class="btn btn-primary" href="javascript:void(0)" dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-cog fa-fw"></i> ' . label("Action") . '</a><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-caret-down" title="Toggle dropdown menu"></span></a><ul class="dropdown-menu"><li><a href="javascript:void(0)" onclick="Edit_Sale(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> ' . label("Edit") . '</a></li><li><a href="javascript:void(0)" onclick="payaments(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i> ' . label("Payements") . '</a></li><li><a href="javascript:void(0)" onclick="showInvoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-sticky-note" aria-hidden="true"></i> ' . label("invoice") . '</a></li><li><a href="javascript:void(0)" onclick="showTicket(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-ticket fa-fw" aria-hidden="true"></i> ' . label("Receipt") . '</a></li><li class="divider"></li><li><a href="javascript:void(0)" onclick="delete_invoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> ' . label("Delete") . '</a></li></ul></div>';
            else
                $row[] = '<div class="btn-group"><a class="btn btn-primary" href="javascript:void(0)" dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-cog fa-fw"></i> ' . label("Action") . '</a><a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-caret-down" title="Toggle dropdown menu"></span></a><ul class="dropdown-menu"><li><a href="javascript:void(0)" onclick="Edit_Sale(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> ' . label("Edit") . '</a></li><li><a href="javascript:void(0)" onclick="payaments(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-credit-card-alt fa-fw" aria-hidden="true"></i> ' . label("Payements") . '</a></li><li><a href="javascript:void(0)" onclick="showInvoice(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-sticky-note" aria-hidden="true"></i> ' . label("invoice") . '</a></li><li><a href="javascript:void(0)" onclick="showTicket(' . "'" . $invoice->id . "'" . ')"><i class="fa fa-ticket fa-fw" aria-hidden="true"></i> ' . label("Receipt") . '</a></li></ul></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invoice->count_all(),
            "recordsFiltered" => $this->invoice->count_filtered(),
            "data" => $data
        );
        // output to json format
        echo json_encode($output);
    }

    public function ajax_delete($id)
    {
        $this->invoice->delete_by_id($id);
        $posales = Sale_item::delete_all(array(
            'conditions' => array(
                'sale_id = ?',
                $id
            )
        ));
        echo json_encode(array(
            "status" => TRUE
        ));
    }

    public function ShowTicket($id)
    {
        $sale = Sale::find($id);
        $posales = Sale_item::find('all', array(
            'conditions' => array(
                'sale_id = ?',
                $id
            )
        ));

        $ticket = '<div class="col-md-12"><div class="text-center">' . $this->setting->receiptheader . '</div><div style="clear:both;"><h4 class="text-center">' . label("SaleNum") . '.: ' . sprintf("%05d", $sale->id) . '</h4> <div style="clear:both;"></div><span class="float-left">' . label("Date") . ': ' . $sale->created_at->format('d-m-Y') . '</span><div style="clear:both;"><span class="float-left">' . label("Customer") . ': ' . $sale->clientname . '</span><div style="clear:both;"></div><table class="table" cellspacing="0" border="0"><thead><tr><th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") . '</th></tr></thead><tbody>';

        $i = 1;
        foreach ($posales as $posale) {
            $ticket .= '<tr><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' . $posale->name . '</td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
            $i ++;
        }

        // barcode codding type
        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $ticket .= '</tbody></table><table class="table" cellspacing="0" border="0" style="margin-bottom:8px;"><tbody><tr><td style="text-align:left;">' . label("TotalItems") . '</td><td style="text-align:right; padding-right:1.5%;">' . $sale->totalitems . '</td><td style="text-align:left; padding-left:1.5%;">' . label("Total") . '</td><td style="text-align:right;font-weight:bold;">' . number_format((float)$sale->subtotal, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
        // if there is a discount it will be displayed
        if (intval($sale->discount))
            $ticket .= '<tr><td style="text-align:left; padding-left:1.5%;"></td><td style="text-align:right;font-weight:bold;"></td><td style="text-align:left;">' . label("Discount") . '</td><td style="text-align:right; padding-right:1.5%;font-weight:bold;">' . $sale->discount . '</td></tr>';
            // same for the order tax
        if (intval($sale->tax))
            $ticket .= '<tr><td style="text-align:left;"></td><td style="text-align:right; padding-right:1.5%;font-weight:bold;"></td><td style="text-align:left; padding-left:1.5%;">' . label("tax") . '</td><td style="text-align:right;font-weight:bold;">' . $sale->tax . '</td></tr>';

        $ticket .= '<tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("GrandTotal") . '</td><td colspan="2" style="border-top:1px dashed #000; padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sale->total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr><tr>';

        $PayMethode = explode('~', $sale->paidmethod);
        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCard") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">xxxx xxxx xxxx ' . substr($PayMethode[1], - 4) . '</td></tr><tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCardHold") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td></tr>';
                break;
            case '2': // case ckeck
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("ChequeNum") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[1] . '</td></tr>';
                break;
            default:
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("Paid") . ' (' . label("Cash") . ')</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sale->firstpayement, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
        }

        $payements = Payement::find('all', array('conditions' => array('sale_id = ?', $id)));
        if($payements){
           $ticket .= '<tr>';
          foreach ($payements as $pay) {
             $PayMethode = explode('~', $pay->paidmethod);
             switch ($PayMethode[0]) {
                case '1': // case Credit Card
                    $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCard") . ' (xxxx xxxx xxxx ' . substr($PayMethode[1], - 4) . ')</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">'. number_format((float)$pay->paid, $this->setting->decimals, '.', '') .' ' . $this->setting->currency . '</td></tr><tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCardHold") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td></tr>';
                    break;
                case '2': // case ckeck
                    $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("ChequeNum") . ' (' . $PayMethode[1] . ')</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">'.number_format((float)$pay->paid, $this->setting->decimals, '.', '').' ' . $this->setting->currency . '</td></tr>';
                    break;
                default:
                    $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("Paid") . ' (' . label("Cash") . ')</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">'. number_format((float)$pay->paid, $this->setting->decimals, '.', '') .' ' . $this->setting->currency . '</td></tr>';
           }
          }
       } else{
          $ticket .= '</tbody></table>';
       }

        $ticket .= '<div style="border-top:1px solid #000; padding-top:10px;"><span class="float-left">' . $this->setting->companyname . '</span><span class="float-right">' . label("Tel") . ' ' . $this->setting->phone . '</span><div style="clear:both;"><center><img style="margin-top:30px" src="' . site_url('pos/GenerateBarcode/' . sprintf("%05d", $sale->id) . '/' . $bcs . '/' . $height . '/' . $width) . '" alt="' . $sale->id . '" /></center><div class="text-center" style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;margin-top:40px;">' . $this->setting->receiptfooter . '</div></div>';

        echo $ticket;
    }

    public function showInvoice($id)
    {
        $sale = Sale::find($id);
        $posales = Sale_item::find('all', array(
            'conditions' => array(
                'sale_id = ?',
                $id
            )
        ));
        $client = Customer::find('first', array(
            'conditions' => array(
                'id = ?',
                $sale->client_id
            )
        ));
        $ClientData = $client ? 'Customer: ' . $client->name . '<br>' . $client->phone . '<br>' . $client->email : label('WalkinCustomer');

        $ticket = '<div class="col-sm-12"><table width="100%"><tr><td align="left"><span class="float-left">' . $this->setting->companyname . '<br>' . label("Tel") . ' ' . $this->setting->phone . '</span></td><td align="right"><img src="files/Setting/' . $this->setting->logo . '" alt="" width="100px" Style="margin:15px;float:right;"/></td></tr></table></div><div style="clear:both;"></div><h4 class="float-left">#' . sprintf("%05d", $sale->id) . '</h4> <div style="clear:both;"></div><span style="font-size:40px;font-weight:600;padding:5px;background-color:#415472;color:#fff;">' . label("INVOICE") . '</span><br><br><br><div style="clear:both;"></div><table width="100%"><tr><td align="left"><span class="float-left">' . label("Date") . ': ' . $sale->created_at->format('d-m-Y') . '</span></td><td align="right"><span Style="margin-bottom:15px;float:right;width:100%;text-align:right">' . $ClientData . '</span></td></tr></table><div style="clear:both;"></div><div style="clear:both;"></div><table class="table" cellspacing="0" border="0"><thead><tr style="background-color:#555;color:#fff;font-weight:600"><th><em>#</em></th><th>' . label("Product") . '</th><th>' . label("Quantity") . '</th><th>' . label("SubTotal") . '</th></tr></thead><tbody>';

        $i = 1;
        foreach ($posales as $posale) {
            $ticket .= '<tr><td style="text-align:center; width:30px;">' . $i . '</td><td style="text-align:left; width:180px;">' . $posale->name . '</td><td style="text-align:center; width:50px;">' . $posale->qt . '</td><td style="text-align:right; width:70px; ">' . number_format((float)($posale->qt * $posale->price), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
            $i ++;
        }

        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $ticket .= '</tbody></table><div class="col-xs-4  col-xs-offset-8"><table class="table table-striped" cellspacing="0" border="0" style="margin:20px 0 30px 0;"><thead><tr><td style="text-align:left; padding:3px;">' . label("TotalItems") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . $sale->totalitems . '</td></tr></thead><tbody><tr><td style="text-align:left; padding:3px;">' . label("Total") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . number_format((float)$sale->subtotal, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';

        if (intval($sale->discount))
            $ticket .= '<tr><td style="text-align:left; padding:3px;">' . label("Discount") . '</td><td style="text-align:right; padding:3px; padding-right:1.5%;font-weight:bold;">' . $sale->discount . '</td></tr>';
        if (intval($sale->tax))
            $ticket .= '<tr><td style="text-align:left; padding:3px; padding-left:1.5%;">' . label("tax") . '</td><td style="text-align:right; padding:3px;font-weight:bold;">' . $sale->tax . '</td></tr>';
        $ticket .= '<tr style="background-color:#415472;color:#fff;font-weight:600;font-size:20px"><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format((float)$sale->total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr><tr>';

        $PayMethode = explode('~', $sale->paidmethod);
        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCard") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">xxxx xxxx xxxx ' . substr($PayMethode[1], - 4) . '</td></tr><tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("CreditCardHold") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td></tr></tbody></table></div>';
                break;
            case '2': // case ckeck
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">' . label("ChequeNum") . '</td><td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[1] . '</td></tr></tbody></table></div>';
                break;
            default:
                $ticket .= '</tbody></table></div>';
        }
        $ticket .= '<div class="text-center" style="clear:both;padding-bottom:10px; padding-top:10px; width:100%; background-color:#eee"><span style="font-size:9px;text-transform:uppercase;letter-spacing: 4px;">' . $this->setting->companyname . '<br>' . $this->setting->phone . '</span></div>';

        echo $ticket;
    }

    public function Edit_Ajax($id)
    {
        $customers = Customer::find('all');
        $sale = Sale::find($id);
        switch ($sale->status) {
            case 1: // case Credit Card
                $satus = 'unpaid';
                break;
            case 2: // case ckeck
                $satus = 'Partiallypaid';
                break;
            default:
                $satus = 'paid';
        }
        $change = ($sale->total - $sale->paid) > 0 ? ($sale->total - $sale->paid) : '';
        $content = '<div class="row"><div class="col-md-12"><h4><b>' . label("Total") . '</b> ' . $sale->total . ' ' . $this->setting->currency . ' <b>&emsp;' . label("Paid") . ' :</b> ' . $sale->paid . ' ' . $this->setting->currency . '<b> &emsp;' . label("change") . ' :</b> ' . ($sale->total - $sale->paid) . ' ' . $this->setting->currency . '</h4><div class="form-group"><label for="customerSelect">' . label("changeClient") . '</label><select class="form-control" id="customerSelect"><option value="0" >' . label("WalkinCustomer") . '</option>';

        foreach ($customers as $customer) {
            $Selected = $customer->id == $sale->client_id ? 'selected' : '';
            $content .= '<option value="' . $customer->id . '" ' . $Selected . '>' . $customer->name . '</option>';
        }

        $content .= '</select></div><div class="form-group"><label for="changeStatus">' . label("changeStatus") . ' <span class="' . $satus . '">' . label($satus) . '<span></label><select class="form-control" id="changeStatus"><option value="' . $sale->status . '" >' . label("changeStatus") . '</option><option value="0" >' . label("paid") . '</option><option value="1" >' . label("unpaid") . '</option><option value="2" >' . label("Partiallypaid") . '</option></select></div></div><input type="hidden" id="ClientId" value="' . $id . '" />';

        echo $content;
    }

    public function Update_Sale($id)
    {
        $sale = Sale::find($id);
        date_default_timezone_set($this->setting->timezone);
        $date = date("Y-m-d H:i:s");
         $sale->update_attributes(array(
             'client_id' => $this->input->post('customerId'),
             'clientname' => $this->input->post('customer'),
             'status' => $this->input->post('Status'),
             'modified_at' => $date
         ));
    }

    public function payaments($id) {

      $sale = Sale::find($id);
      $change = ($sale->total - $sale->paid) > 0 ? ($sale->total - $sale->paid) : '';
      $content = '<div class="row"><div class="col-md-12"><h4><b>' . label("Total") . '</b> ' . number_format((float)$sale->total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . ' <b>&emsp;' . label("Paid") . ' :</b> ' . number_format((float)$sale->paid, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '<b> &emsp;' . label("change") . ' :</b> ' . number_format((float)($sale->total - $sale->paid), $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</h4></div></div>';

      $content .= '<div class="col-md-12"><table class="table"><thead><tr><th width="20%">'.label("Date").'</th><th width="30%">'.label("Createdby").'</th><th width="20%">'.label("Amount").'</th><th width="20%">'.label("Method").'</th><th width="10%"> </th></tr></thead><tbody class="itemslist">';

      $PayMethode = explode('~', $sale->paidmethod);
      $content .= '<tr><td>'.$sale->created_at->format('d-m-Y').'</td>
      <td>'.$sale->created_by.'</td>
      <td>'.number_format((float)$sale->firstpayement, $this->setting->decimals, '.', '').'</td>
      <td>'.($PayMethode[0] !== '1' ? ($PayMethode[0] !== '2' ? label("Cash") : label("Cheque")) : label("CreditCard")).'</td>
      <td> </td></tr>';
      $payements = Payement::find('all', array('conditions' => array('sale_id = ?', $id)));
      if($payements){
         foreach ($payements as $pay) {
            $PayMethode = explode('~', $pay->paidmethod);
            $content .= '<tr><td>'.$pay->date->format('d-m-Y').'</td>
            <td>'.$pay->created_by.'</td>
            <td>'.number_format((float)$pay->paid, $this->setting->decimals, '.', '').'</td>
            <td>'.($PayMethode[0] !== '1' ? ($PayMethode[0] !== '2' ? label("Cash") : label("Cheque")) : label("CreditCard")).'</td>
            <td><a href="javascript:void(0)" onclick="deletepayement('.$pay->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a></td></tr>';
         }
      }
      $content .= '  </tbody>
        </table></div> <button class="btn btn-add col-md-12" onclick="addpymntBtn()" style="margin-bottom:0">'.label("AddPayement").'</button>';
      echo $content;
   }

   public function Addpayament($type){

      date_default_timezone_set($this->setting->timezone);
      $date = date("Y-m-d H:i:s");
      $_POST['date'] = $date;
      $_POST['register_id'] = $this->register;
      $register = Register::find($this->register);
      $store = Store::find($register->store_id);
      if ($type == 2) {
          try {
             Stripe::setApiKey($this->setting->stripe_secret_key);
             $myCard = array(
                  'number' => $this->input->post('ccnum'),
                  'exp_month' => $this->input->post('ccmonth'),
                  'exp_year' => $this->input->post('ccyear'),
                  "cvc" => $this->input->post('ccv')
             );
             $charge = Stripe_Charge::create(array(
                  'card' => $myCard,
                  'amount' => (floatval($this->input->post('paid')) * 100),
                  'currency' => $this->setting->currency
             ));
             echo "<p class='bg-success text-center'>" . label('saleStripesccess') . '</p>';
          } catch (Stripe_CardError $e) {
             // Since it's a decline, Stripe_CardError will be caught
             $body = $e->getJsonBody();
             $err = $body['error'];
             echo "<p class='bg-danger text-center'>" . $err['message'] . '</p>';
          }
      }
      unset($_POST['ccnum']);
      unset($_POST['ccmonth']);
      unset($_POST['ccyear']);
      unset($_POST['ccv']);
      Payement::create($_POST);
      $sale = Sale::find($this->input->post('sale_id'));

      $sale->paid = $sale->paid + $this->input->post('paid');
      $statu = $sale->paid - $sale->total;
      $sale->status = $statu >= 0 ? '0' : '2';
      $sale->save();

      echo json_encode(array(
          "status" => TRUE
      ));

   }

   public function deletepayement($id, $sale_id)
   {
      $payement = Payement::find($id);

      $sale = Sale::find($sale_id);
      $sale->paid = $sale->paid - $payement->paid;
      $statu = $sale->paid - $sale->total;
      $sale->status = $statu === -floatval($sale->total) ? '1' : '2';
      $sale->save();

      $payement->delete();
   }
}
