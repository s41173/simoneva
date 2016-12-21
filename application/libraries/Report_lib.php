<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_lib extends Main_Model {

    public function __construct($deleted=NULL)
    {
        $this->deleted = $deleted;
        $this->tableName = '';
        $this->account = new Account_lib();
        $this->transaction = new Transaction_lib();
        $this->balance = new Balance_lib();       
        $this->category = new Acategory_lib();
    }

    protected $account,$transaction,$balance,$category;
    
     // get trans account based parent account code ex:511 0101       
    function get_trans_acc($parent,$dppa_id,$month,$year)
    {        
        $accounts = $this->account->get_account_based_parent($parent)->result();
        foreach($accounts as $res)
        {
           $pagu = $this->balance->get_budet($dppa_id,'null',$res->id,$year);
           $sp2d = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,0);
           $prev = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,2);
           $prog = $this->transaction->get_total_monthly($dppa_id,'null',$res->id,$month,$year,1);

           echo $this->table($res->code, ucfirst($res->name), $pagu,$sp2d,$prev,$prog);
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
           $prog = $this->transaction->get_total_monthly_parent_balance($dppa_id,$res->id,$month,$year,1);
            
           echo $this->table($res->code, ucfirst($res->name), $pagu,$sp2d,$prev,$prog,'top-rekening');
           $this->get_trans_acc($res->id,$dppa_id,$month,$year);
        }
        
    }
    
    // batas belanja 2 =====================================================
    
    function get_trans_based_jenis_kegiatan($dppa,$program,$month,$year)
    {    
       $kegiatan = $this->category->get_child_category($program)->result();
       if ($kegiatan)
       {
           foreach ($kegiatan as $res)
           {
              $pagu = $this->balance->get_balance_based_child_program($dppa,$year,$res->id); 
              $sp2d = $this->transaction->get_total_monthly_based_kegiatan($dppa,$res->id,'null',$month,$year,0);
              $prev = $this->transaction->get_total_monthly_based_kegiatan($dppa,$res->id,'null',$month,$year,2);
              $prog = $this->transaction->get_total_monthly_based_kegiatan($dppa,$res->id,'null',$month,$year,1);
               
              echo $this->table($res->code, ucfirst($res->name), $pagu,$sp2d,$prev,$prog,'kegiatan');
              $this->get_trans_based_kode_belanja_kegiatan($dppa,$res->id,$month,$year);   
           }
       }    
    }
    
    function get_trans_based_kode_belanja_kegiatan($dppa,$acategory_id,$month,$year)
    {  
       $belanja = $this->balance->get_category_account_based_acategory($acategory_id,$dppa,$year)->result();
       if ($belanja)
       {
           foreach ($belanja as $res)
           {
$pagu = $this->balance->get_balance_based_program_category_account($res->category,$acategory_id,$dppa,$year); 
$sp2d = $this->transaction->get_total_based_program_category_acc($res->category,$acategory_id,$dppa,$month,$year,0);
$prev = $this->transaction->get_total_based_program_category_acc($res->category,$acategory_id,$dppa,$month,$year,2); 
$prog = $this->transaction->get_total_based_program_category_acc($res->category,$acategory_id,$dppa,$month,$year,1);  
    
    echo $this->table($res->category, $this->account->get_belanja_type($res->category), $pagu,$sp2d,$prev,$prog,'kategori-belanja');
    $this->get_trans_parent_rekening_kegiatan($acategory_id,$res->category,$dppa,$month,$year); 
               
           }
       }
    }
    
    // fungsi mendapatkan balance berdasarkan rekening kegiatan     11,522,5,1,2016
    function get_trans_parent_rekening_kegiatan($acategory,$category,$dppa,$month,$year)
    {
             
$results = $this->account->get_parent_based_category_belanja_program($acategory,$category,$dppa,$year)->result();
       if ($results)
       {
           foreach($results as $res)
           {
$pagu = $this->balance->get_balance_based_parent_acc($acategory,$res->parent_id,$dppa,$year); // $res->parent_id == parent
$sp2d = $this->transaction->get_total_based_program_top_acc($category,$acategory,$res->parent_id,$dppa,$month,$year,0);
$prev = $this->transaction->get_total_based_program_top_acc($category,$acategory,$res->parent_id,$dppa,$month,$year,2); 
$prog = $this->transaction->get_total_based_program_top_acc($category,$acategory,$res->parent_id,$dppa,$month,$year,1);

    echo $this->table($this->account->get_code($res->parent_id), $this->account->get_name($res->parent_id), $pagu,$sp2d,$prev,$prog,'top-rekening');
    $this->get_trans_based_rekening_kegiatan($acategory,$category,$res->parent_id,$dppa,$month,$year);
               
           }
       }
    }
    
    // fungsi mendapatkan balance berdasarkan rekening kegiatan     
    function get_trans_based_rekening_kegiatan($acategory,$category,$parent,$dppa,$month,$year)
    {
$results = $this->account->get_account_category_program_parent($acategory,$category,$parent,$dppa,$year)->result();
       if ($results)
       {
           foreach($results as $res)
           {
             $pagu = $this->balance->get_balance_based_program_account($acategory,$res->id,$dppa,$year);
             $sp2d = $this->transaction->get_total_monthly($dppa,$acategory,$res->id,$month,$year,0);
             $prev = $this->transaction->get_total_monthly($dppa,$acategory,$res->id,$month,$year,2);
             $progress = $this->transaction->get_total_monthly($dppa,$acategory,$res->id,$month,$year,1);
             
             echo $this->table($res->code, ucfirst($res->name),$pagu,$sp2d,$prev,$progress);
               
           }
       }
    }
    
    function table($val1=null,$val2=null,$pagu=0,$sp2d=0,$prev=0,$progress=0,$class='')
    {
        $tot_progress = $prev + $progress;
        $rest = $pagu-$tot_progress;
        
        return "<tr class='$class'>
            <td></td>
            <td align=\"right\"> <nobr>  ".$val1." </nobr></td>
            <td> ".$val2." </td> 
            <td> </td>
            <td> ".idr_format($pagu)." </td>
            <td> ".idr_format($sp2d)." </td>
            <td> ".idr_format($pagu-$sp2d)." </td>
            <td>100</td>
            <td> ".@floatval($sp2d/$pagu*100)." </td>
            <td> ".idr_format($prev)."</td>
            <td> ".idr_format($progress)."</td>
            <td> ".@floatval($progress/$pagu*100)."</td>
            <td> ".idr_format($tot_progress)."</td>
            <td> ".@floatval($tot_progress/$pagu*100)."</td>
            <td> ".idr_format($rest)."</td>
            <td> ".@floatval($rest/$pagu*100)."</td>
           </tr>";
    }
    

}

/* End of file Property.php */
