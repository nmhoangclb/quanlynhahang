<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
        $this->lang->load($lang, $lang);
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;

        $this->setting = Setting::find(1);
    }

    public function getCustomerReport()
    {
        $client_id = $this->input->post('client_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $totals = 0;
        $sales = Sale::find_by_sql("SELECT * FROM `zarest_sales` WHERE client_id = '$client_id' AND created_at between '$start' AND '$end' ORDER BY created_at");
        $result = '<table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%"><thead><tr><th>' . label("Number") . '</th><th>' . label("CustomerName") . '</th><th>' . label("Discount") . '</th><th>' . label("Total") . '</th><th>' . label("Createdby") . '</th><th>' . label("TotalItems") . '</th></tr></thead><tbody>';
        foreach ($sales as $sale) {
            $result .= '<tr><td>' . $sale->id . '</td><td>' . $sale->clientname . '</td><td>' . $sale->discount . '</td><td>' . number_format((float)$sale->total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td><td>' . $sale->created_by . '</td><td>' . $sale->totalitems . '</td></tr>';
            $totals += $sale->total;
        }
        $result .= '</tbody>
      </table>
      <h1>' . label("Total") . ' : <span class="ReportTotal">' . $totals . ' ' . $this->setting->currency . '</span></h1>';

        echo $result;
    }

    public function getProductReport()
    {
        $product_id = $this->input->post('product_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $totalprofit = 0;
        $prduct = Product::find($product_id);
        $prducts = Sale_item::find_by_sql("SELECT * FROM `zarest_sale_items` WHERE product_id = '$product_id' AND date between '$start' AND '$end' ORDER BY date");
        $result = '<table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%"><thead><tr><th>' . label("SaleNum") . '</th><th>' . label("ProductName") . '</th><th>' . label("Cost") . '</th><th>' . label("Price") . '</th><th>' . label("Quantity") . '</th><th>' . label("tax") . '</th><th>' . label("Total") . '</th><th>' . label("Profit") . '</th></tr></thead><tbody>';

        foreach ($prducts as $prd) {
            $tax = $prd->subtotal * intval(substr($prduct->tax, 0, - 1)) / 100;
            $profit = $prd->subtotal - $tax - ($prduct->cost * $prd->qt);
            $result .= '<tr><td>' . $prd->id . '</td><td>' . $prd->name . '</td><td>' . $prduct->cost . ' ' . $this->setting->currency . '</td><td>' . number_format((float)$prd->price, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td><td>' . $prd->qt . '</td><td>' . $prduct->tax . '(' . $tax . ' ' . $this->setting->currency . ')</td><td>' . $prd->subtotal . ' ' . $this->setting->currency . '</td><td>' . number_format((float)$profit, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td></tr>';
            $totalprofit += $profit;
        }

        $result .= '</tbody></table><h1>' . label("TotalProfit") . ' : <span class="ReportTotal">' . $totalprofit . ' ' . $this->setting->currency . '</span></h1>';

        echo $result;
    }

    public function getRegisterReport()
    {
        $store_id = $this->input->post('store_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $TotalRevenue = 0;
        $register = Register::find_by_sql("SELECT * FROM `zarest_registers` WHERE store_id = '$store_id' AND date between '$start' AND '$end' ORDER BY date");
        $result = '<table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%"><thead><tr>
        <th>' . label("Openingtime") . '</th><th>' . label("closedat") . '</th><th>' . label("Openedby") . '</th>
        <th>' . label("Cash") . '</th><th>' . label("CreditCard") . '</th>
        <th>' . label("Cheque") . '</th><th> </th></tr></thead><tbody>';

        foreach ($register as $reg) {
           if($this->user->role === "admin")
            $action = '<div class="btn-group"><a class="btn btn-default" href="javascript:void(0)" onclick="delete_register(' . $reg->id . ')" title="' . label("Delete") . '"><i class="fa fa-times"></i></a></div>';
           else
            $action = '-';
            $result .= '<tr><td><a href="javascript:void(0)" '.($reg->closed_at ? 'onclick="RegisterDetails(' . $reg->id . ')"' : '').'>' . $reg->date->format('Y-m-d h:i:s') . '</a></td>
            <td>' . ($reg->closed_at ? $reg->closed_at : label("Stillopen")) . '</td>
            <td>' . User::find($reg->user_id)->username . '</td>
            <td>' . number_format((float)$reg->cash_total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td>
            <td>' . number_format((float)$reg->cc_total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td>
            <td>' . number_format((float)$reg->cheque_total, $this->setting->decimals, '.', '') . ' ' . $this->setting->currency . '</td>
            <td>'.$action.'</td></tr>';
            $TotalRevenue += $reg->cash_total + $reg->cheque_total + $reg->cc_total;
        }

        $result .= '</tbody></table><h1>' . label("TotalRevenue") . ' : <span class="ReportTotal">' . $TotalRevenue . ' ' . $this->setting->currency . '</span></h1>';

        echo $result;
    }

    public function delete_register($id){

      $register = Register::find($id);
      $sales = Sale::find('all', array(
          'conditions' => array(
             'register_id = ?',
             $id
          )
      ));
      foreach ($sales as $sale) {
         Sale_item::delete_all(array(
             'conditions' => array(
                'sale_id = ?',
                $sale->id
             )
         ));
      }
      Sale::delete_all(array(
          'conditions' => array(
             'register_id = ?',
             $id
          )
      ));
      Payement::delete_all(array(
          'conditions' => array(
             'register_id = ?',
             $id
          )
      ));

      $register->delete();
   }

    public function getyearstats($year)
    {
        $monthly = Sale::find_by_sql("SELECT SUM(IF(MONTH = 1, numRecords, 0)) AS 'january',SUM(IF(MONTH = 1, totaltax, 0)) AS 'januarytax',SUM(IF(MONTH = 1, totaldiscount, 0)) AS 'januarydisc',SUM(IF(MONTH = 2, numRecords, 0)) AS 'feburary',SUM(IF(MONTH = 2, totaltax, 0)) AS 'feburarytax',SUM(IF(MONTH = 2, totaldiscount, 0)) AS 'feburarydisc',SUM(IF(MONTH = 3, numRecords, 0)) AS 'march',SUM(IF(MONTH = 3, totaltax, 0)) AS 'marchtax',SUM(IF(MONTH = 3, totaldiscount, 0)) AS 'marchdisc',SUM(IF(MONTH = 4, numRecords, 0)) AS 'april',SUM(IF(MONTH = 4, totaltax, 0)) AS 'apriltax',SUM(IF(MONTH = 4, totaldiscount, 0)) AS 'aprildisc',SUM(IF(MONTH = 5, numRecords, 0)) AS 'may',SUM(IF(MONTH = 5, totaltax, 0)) AS 'maytax',SUM(IF(MONTH = 5, totaldiscount, 0)) AS 'maydisc',SUM(IF(MONTH = 6, numRecords, 0)) AS 'june',SUM(IF(MONTH = 6, totaltax, 0)) AS 'junetax',SUM(IF(MONTH = 6, totaldiscount, 0)) AS 'junedisc',SUM(IF(MONTH = 7, numRecords, 0)) AS 'july',SUM(IF(MONTH = 7, totaltax, 0)) AS 'julytax',SUM(IF(MONTH = 7, totaldiscount, 0)) AS 'julydisc',SUM(IF(MONTH = 8, numRecords, 0)) AS 'august',SUM(IF(MONTH = 8, totaltax, 0)) AS 'augusttax',SUM(IF(MONTH = 8, totaldiscount, 0)) AS 'augustdisc',SUM(IF(MONTH = 9, numRecords, 0)) AS 'september',SUM(IF(MONTH = 9, totaltax, 0)) AS 'septembertax',SUM(IF(MONTH = 9, totaldiscount, 0)) AS 'septemberdisc',SUM(IF(MONTH = 10, numRecords, 0)) AS 'october',SUM(IF(MONTH = 10, totaltax, 0)) AS 'octobertax',SUM(IF(MONTH = 10, totaldiscount, 0)) AS 'octoberdisc',SUM(IF(MONTH = 11, numRecords, 0)) AS 'november',SUM(IF(MONTH = 11, totaltax, 0)) AS 'novembertax',SUM(IF(MONTH = 11, totaldiscount, 0)) AS 'novemberdisc',SUM(IF(MONTH = 12, numRecords, 0)) AS 'december',SUM(IF(MONTH = 12, totaltax, 0)) AS 'decembertax',SUM(IF(MONTH = 12, totaldiscount, 0)) AS 'decemberdisc',SUM(numRecords) AS total, SUM(totaltax) AS totalstax, SUM(totaldiscount) AS totaldisc FROM ( SELECT id, MONTH(created_at) AS MONTH, ROUND(sum(total)) AS numRecords, ROUND(sum(taxamount)) AS totaltax, ROUND(sum(discountamount)) AS totaldiscount FROM zarest_sales WHERE DATE_FORMAT(created_at, '%Y') = $year GROUP BY id, MONTH ) AS SubTable1");
        $monthlyExp = Expence::find_by_sql("SELECT SUM(IF(MONTH = 1, numRecords, 0)) AS 'january', SUM(IF(MONTH = 2, numRecords, 0)) AS 'feburary', SUM(IF(MONTH = 3, numRecords, 0)) AS 'march', SUM(IF(MONTH = 4, numRecords, 0)) AS 'april', SUM(IF(MONTH = 5, numRecords, 0)) AS 'may', SUM(IF(MONTH = 6, numRecords, 0)) AS 'june', SUM(IF(MONTH = 7, numRecords, 0)) AS 'july', SUM(IF(MONTH = 8, numRecords, 0)) AS 'august', SUM(IF(MONTH = 9, numRecords, 0)) AS 'september', SUM(IF(MONTH = 10, numRecords, 0)) AS 'october', SUM(IF(MONTH = 11, numRecords, 0)) AS 'november', SUM(IF(MONTH = 12, numRecords, 0)) AS 'december', SUM(numRecords) AS total FROM ( SELECT id, MONTH(date) AS MONTH, ROUND(sum(amount)) AS numRecords FROM zarest_expences WHERE DATE_FORMAT(date, '%Y') = $year GROUP BY id, MONTH ) AS SubTable1");
        $result = '<table class="StatTable"><tr><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->januarytax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->januarydisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->january . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->january . ' ' . $this->setting->currency . '</span>' . label('January') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->feburarytax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->feburarydisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->feburary . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->feburary . ' ' . $this->setting->currency . '</span>' . label('February') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->marchtax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->marchdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->march . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->march . ' ' . $this->setting->currency . '</span>' . label('March') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->apriltax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->aprildisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->april . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->april . ' ' . $this->setting->currency . '</span>' . label('April') . '</td></tr><tr><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->maytax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->maydisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->may . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->may . ' ' . $this->setting->currency . '</span>' . label('May') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->junetax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->junedisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->june . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->june . ' ' . $this->setting->currency . '</span>' . label('June') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->julytax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->julydisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->july . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->july . ' ' . $this->setting->currency . '</span>' . label('July') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->augusttax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->augustdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->august . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->august . ' ' . $this->setting->currency . '</span>' . label('August') . '</td></tr><tr><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->septembertax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->septemberdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->september . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->september . ' ' . $this->setting->currency . '</span>' . label('September') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->octobertax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->octoberdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->october . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->october . ' ' . $this->setting->currency . '</span>' . label('October') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->novembertax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->novemberdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->november . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->november . ' ' . $this->setting->currency . '</span>' . label('November') . '</td><td><span class="revenuespan" data-toggle="tooltip" data-placement="top"  data-html="true" title="<h5>' . label('tax') . ' : <b>' . $monthly[0]->decembertax . ' ' . $this->setting->currency . '</b> <br><br> ' . label('Discount') . ' : <b>' . $monthly[0]->decemberdisc . ' ' . $this->setting->currency . '</b></h5>">' . $monthly[0]->december . ' ' . $this->setting->currency . '</span><span class="expencespan">' . $monthlyExp[0]->december . ' ' . $this->setting->currency . '</span>' . label('December') . '</td></tr></table>';

        echo $result;
    }

    /**
     * ****************** register functions ***************
     */
    public function RegisterDetails($id)
    {
        $register = Register::find($id);
        try{$user = User::find($register->user_id);}catch (\Exception $e){$user = "-";}
        try{$user2 = User::find($register->closed_by);}catch (\Exception $e){$user2 = "-";}

        $CashinHand = number_format((float)$register->cash_inhand, $this->setting->decimals, '.', '');
        $date = $register->date;
        $closedate = $register->closed_at;
        $createdBy = $user->firstname . ' ' . $user->lastname;
        $closedBy = $user2->firstname . ' ' . $user2->lastname;
        $total = $register->cheque_total + $register->cc_total + $register->cash_total;
        $subtotal = $register->cash_sub + $register->cc_sub + $register->cheque_sub;

        $data = '<div class="col-md-3"><blockquote><footer>' . label("Openedby") . '</footer><p>' . $createdBy . '</p></blockquote></div>
        <div class="col-md-3"><blockquote><footer>' . label("CashinHand") . '</footer>
        <p>' . $CashinHand . ' ' . $this->setting->currency . '</p></blockquote></div><div class="col-md-4"><blockquote><footer>' . label("Openingtime") . '</footer>
        <p>' . $date->format('Y-m-d h:i:s') . '</p></blockquote></div><div class="col-md-2"><img src="' . site_url() . '/assets/img/register.svg" alt=""></div>
        <h2>' . label("PaymentsSummary") . '</h2><table class="table table-striped"><tr><th width="25%">' . label("PayementType") . '</th>
        <th width="25%">' . label("EXPECTED") . ' (' . $this->setting->currency . ')</th><th width="25%">' . label("COUNTED") . ' (' . $this->setting->currency . ')</th>
        <th width="25%">' . label("DIFFERENCES") . ' (' . $this->setting->currency . ')</th></tr><tr><td>' . label("Cash") . '</td>
        <td><span id="expectedcash">' . number_format((float)$register->cash_total, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="countedcash">' . number_format((float)$register->cash_sub, $this->setting->decimals, '.', '') . '</span></td><td>
        <span id="diffcash">' . number_format((float)($register->cash_sub - $register->cash_total), $this->setting->decimals, '.', '') . '</span></td>
        </tr><tr><td>' . label("CreditCard") . '</td>
        <td><span id="expectedcc">' . number_format((float)$register->cc_total, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="countedcc">' . number_format((float)$register->cc_sub, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="diffcc">' . number_format((float)($register->cc_sub - $register->cc_total), $this->setting->decimals, '.', '') . '</span></td>
        </tr><tr><td>' . label("Cheque") . '</td>
        <td><span id="expectedcheque">' . number_format((float)$register->cheque_total, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="countedcheque">' . number_format((float)$register->cheque_sub, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="diffcheque">' . number_format((float)($register->cheque_sub - $register->cheque_total), $this->setting->decimals, '.', '') . '</span></td></tr>
        <tr class="warning"><td>' . label("Total") . '</td>
        <td><span id="total">' . number_format((float)$total, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="countedtotal">' . number_format((float)$subtotal, $this->setting->decimals, '.', '') . '</span></td>
        <td><span id="difftotal">' . number_format((float)($subtotal - $total), $this->setting->decimals, '.', '') . '</span></td></tr>
        </table><p>- ' . label("ClosedRegister") . ' ' . $closedBy . ' ' . label("at") . ' ' . $closedate . '</p><div  class="form-group"><h2>' . label("note") . '</h2><p>' . $register->note . '</p></div>';

        echo $data;
    }


    public function getStockReport()
    {
        $store_id = $this->input->post('stock_id');
        $id = substr($store_id, 1);
        $products = Product::find('all');
        if(strcmp($store_id[0], "S"))
         $stype = 'warehouse_id';
        else
         $stype = 'store_id';
         // Stock::find('all', array('conditions' => array('store_id = ?', $id)));
        $result = '<table id="Table" class="table table-striped table-bordered" cellspacing="0" width="100%"><thead><tr>
        <th>' . label("Product") . ' ('.label("ProductCode").')</th>
        <th>' . label("Quantity") . '</th></tr></thead><tbody>';

        foreach ($products as $prod) {
           if($prod->type == '0'){
           $class = '';
           if(!($stock = Stock::find('first', array('conditions' => array($stype.' = ? AND product_id = ?', $id, $prod->id)))))
            $stock = '-';
         else
            $stock = $stock->quantity;

           if($stock < $prod->alertqt)
              $class = 'danger';
            $result .= '<tr class='.$class.'>
            <td>' . $prod->name . ' ('.$prod->code.')</td>
            <td>' . $stock . '</td></tr>';
            }
        }

        $result .= '</tbody></table>';

        echo $result;
    }
}
