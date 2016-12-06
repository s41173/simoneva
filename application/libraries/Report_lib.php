<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = '';
        $this->account = new Account_lib();
        $this->transaction = new Transaction_lib();
        $this->balance = new Balance_lib();       
    }

    protected $account,$transaction,$balance;
    
     // get trans account based parent account code ex:511 0101       
    function get_trans_acc($parent,$dppa_id,$month,$year)
    {        
        $accounts = $this->account->get_account_based_parent($parent)->result();
        foreach($accounts as $res)
        {
           $pagu = $this->balance->get_budet($dppa_id,'null',$res->id,$year);
           $sp2d = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,0);
           $prev = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,2);
           $progress = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,1);
           $tot_progress = $prev + $progress;
           $rest = $pagu-$tot_progress;     
            
           ?>
            <tr>
            <td> </td>
            <td align="right"> <nobr> <?php echo $res->code; ?> </nobr></td>
            <td> <?php echo $res->name ?> </td> 
            <td> </td>
            <td> <?php echo idr_format($pagu); ?> </td>
            <td> <?php echo idr_format($sp2d); ?> </td>
            <td> <?php echo idr_format($pagu-$sp2d); ?> </td>
            <td>100</td>
            <td> <?php echo @floatval($sp2d/$pagu*100); ?> </td>
            <td> <?php echo idr_format($prev); ?> </td>
            <td> <?php echo idr_format($progress); ?> </td>
            <td> <?php echo @floatval($progress/$pagu*100); ?> </td>
            <td> <?php echo idr_format($tot_progress); ?> </td>
            <td> <?php echo @floatval($tot_progress/$pagu*100); ?> </td>
            <td> <?php echo idr_format($rest); ?> </td>
            <td> <?php echo @floatval($rest/$pagu*100); ?> </td>
           </tr> 
           <?php
        }
    }
    
    // get trans account based parent account code ex:511 0101       
    function get_trans_parent_acc($code,$dppa_id,$month,$year)
    {   
        $accounts = $this->account->get_account_parent($code)->result();
        foreach($accounts as $res)
        {
           $pagu = $this->balance->get_account_parent_balance($dppa_id,$year,$res->id);
           $sp2d = $this->transaction->get_total_monthly_parent_balance($dppa_id,$res->id,$month,$year,0);
           $prev = $this->transaction->get_total_monthly_parent_balance($dppa_id,$res->id,$month,$year,2);
           $progress = $this->transaction->get_total_monthly_parent_balance($dppa_id,$res->id,$month,$year,1);
           $tot_progress = $prev + $progress;
           $rest = $pagu-$tot_progress;     
            
           ?>
            <tr>
            <td></td>
            <td align="right"> <nobr> <?php echo $res->code; ?> </nobr></td>
            <td> <?php echo $res->name ?> </td> 
            <td> </td>
            <td> <?php echo idr_format($pagu); ?> </td>
            <td> <?php echo idr_format($sp2d); ?> </td>
            <td> <?php echo idr_format($pagu-$sp2d); ?> </td>
            <td>100</td>
            <td> <?php echo @floatval($sp2d/$pagu*100); ?> </td>
            <td> <?php echo idr_format($prev); ?> </td>
            <td> <?php echo idr_format($progress); ?> </td>
            <td> <?php echo @floatval($progress/$pagu*100); ?> </td>
            <td> <?php echo idr_format($tot_progress); ?> </td>
            <td> <?php echo @floatval($tot_progress/$pagu*100); ?> </td>
            <td> <?php echo idr_format($rest); ?> </td>
            <td> <?php echo @floatval($rest/$pagu*100); ?> </td>
           </tr> 
           <?php $this->get_trans_acc($res->id,$dppa_id,$month,$year);
        }
        
    }
    

}

/* End of file Property.php */
