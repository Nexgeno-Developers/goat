<?php 
   $vyapari = $this->db->where('vyapari_id', $vyapari_id)->get('app_vyapari')->row_array();
   if(empty($vyapari))
   {
       redirect(route('dashboard'));
   }
?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
          <div class="row">
        <div class="col-md-10 col-7">
        <h4 class="page-title vyapdet">
        <i class="mdi mdi-book title_icon"></i> <?php echo get_phrase($page_title); ?>
            <!--Allocate QR-->
            <!--Allocate Pandaal-->
            </h4>
        </div>

        <?php if(access('allocate_pass_button')){ ?>
        <div class="col-md-2 col-5">
            <button type="button" class="btn btn-outline-success btn-rounded alignToTitle pass" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/allocate-qrcode/'.$vyapari['vyapari_id']); ?>', '<?php echo get_phrase('pass_allocate'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_passes'); ?></button>
        </div>
        <?php } ?>

       <?php if(access('allocate_pandol')){ ?>
        <div class="col-md-2 col-5 d-none">
           <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle pandol" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/edit-pandal/'.$vyapari['vyapari_id']); ?>', '<?php echo get_phrase('pandol_allocate'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_pandol'); ?></button>
        </div>
        <?php } ?>
        
        <div>
      </div></div>
          
          
       
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"> 
                <div class="vyapari_content">
                    <div class="row tclass1">
                        <div class="col-md-1 col-12 mb-2 vpdimg"><?= $vyapari['photo'] ? '<a target="_blank" href="'.base_url().'uploads/vyapari_photo/'.$vyapari['photo']. '?' . time() . '"><img width="70px" height="70px" src="'.base_url().'uploads/vyapari_photo/'.$vyapari['photo']. '?' . time() . '"></a>' : null; ?></div>
                        <div class="col-md-2 col-6">
                            <p><span>Vyapari ID :</span> <?= vyapari_id($vyapari['vyapari_id']); ?></p>
                            <p><span>State :</span> <?= $vyapari['state']; ?></p>
                        </div>
                        <div class="col-md-2 col-6">
                            <p><span>Name :</span> <?= $vyapari['name']; ?></p>
                            <p><span>Location :</span> <?= $vyapari['locality']; ?> </p>
                            </div>
                        <div class="col-md-2 col-6">
                            <p><span>Phone :</span> <?= $vyapari['phone']; ?></p>
                            <p><span>Address :</span> <?= $vyapari['address']; ?></p>
                            </div>
                        <div class="col-md-3 col-6">
                            <p><span>Aadhar No :</span> <?= $vyapari['aadhar_no']; ?></p>
                            
                        <?php
                        $pandal = array();
                        $pandaal__no = $this->db->select('pandaal_no')->from('app_qrcode')->where('vyapari_id', $vyapari['vyapari_id'])->group_by('pandaal_no')->get()->result(); 
                        foreach ($pandaal__no as $row) {
                                $pandal[] = $row->pandaal_no; // Append each pandaal_no to the $pandal array
                            }
                        ?>
                        <p><span>Pandol No :</span> <?php
                                                    if ($pandal) {
                                                        echo implode(", ",$pandal);
                                                    } else {
                                                        echo 'Not Allocated';
                                                    }
                                                ?></p>
                                                
                                                    <?php
                        $receipt = array();
                        $receipt__no = $this->db->select('receipt_no')->from('app_qrcode')->where('vyapari_id', $vyapari['vyapari_id'])->group_by('receipt_no')->get()->result(); 
                        foreach ($receipt__no as $row) {
                                $receipt[] = $row->receipt_no; // Append each pandaal_no to the $pandal array
                            }
                        ?>                   
                            <p><span>Receipt No :</span> </span> <?php
                                                    if ($receipt) {
                                                        echo implode(", ",$receipt);
                                                    } else {
                                                        echo '  -  ';
                                                    }
                                                ?></p>
                            </div>
                            <?php if(access('printid_button')){ ?>
                        <div class="col-md-2 col-4"><a target="_blank" class="btn btn-success printbtn" href="<?php echo base_url('superadmin/manage_vyapari/print/'.$vyapari['vyapari_id']); ?>">Print</a>
                            
                    </div>
                    <?php } ?>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>


<?php 
    $this->db->select('*');
    $this->db->from('app_qrcode use index (vyapari_id)');
    $this->db->where('vyapari_id', $vyapari['vyapari_id']);
    $this->db->order_by('qrcode', 'asc');
    $vyapari_qrcodes = $this->db->get()->result_array();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body"> 
                <div class="vyapari_qrcodes">
                
                <div class="row totaldiv">
                    <div class="col-md-7">
                        <div class="flex_passes">
                        <h4 id="qrtotal">Total Pass: <?php echo count($vyapari_qrcodes); ?></h4>
                        <?php
                            $exit_pass_count = count(array_filter($vyapari_qrcodes, function($row) {
                                return $row['status'] === 'exit';
                            }));
                            
                            $balance_pass_count = count(array_filter($vyapari_qrcodes, function($row) {
                                return $row['status'] !== 'exit';
                            }));
                        ?>
                        <h6 id="qrexit">Exit Pass: <?php echo $exit_pass_count; ?> </h6>
                        <h6 id="qrbalance">Balance Pass: <?php echo $balance_pass_count; ?> </h6>
                        </div>
                                               
                    </div>
                <?php if(access('manage_bulk_pass_button')){ ?>  
                <div class="col-md-3 col-6 serhbox">
                    <select id="actionSelect" name="action" class="form-control action">
                        <option value="" data-event="alert('select action first!')">Bulk actions</option>
                        <option value="block" data-event="rightModal('<?php echo site_url('modal/popup/vyapari/bulk-complaint-qrcode/'.$vyapari['vyapari_id'].'/block'); ?>', '<?php echo get_phrase('block_qrcode'); ?>')">Block</option>
                        <option value="unblock" data-event="rightModal('<?php echo site_url('modal/popup/vyapari/bulk-complaint-qrcode/'.$vyapari['vyapari_id'].'/unblock'); ?>', '<?php echo get_phrase('unblock_qrcode'); ?>')">Unblock</option>
                        <?php if($this->session->userdata('user_id') == 1): ?>
                        <option value="delete" data-event="rightModal('<?php echo site_url('modal/popup/vyapari/bulk-delete-qrcode/'.$vyapari['vyapari_id'].'/delete'); ?>', '<?php echo get_phrase('delete_qrcode'); ?>')">Delete</option>
                        <option value="transfer" data-event="rightModal('<?php echo site_url('modal/popup/vyapari/bulk-transfer-qrcode/'.$vyapari['vyapari_id'].'/transfer'); ?>', '<?php echo get_phrase('transfer_qrcode'); ?>')">Transfer</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="col-md-2 col-6 apbtn">
                    <button id="applyButton" type="button" class="btn btn-secondary btn-block" onclick="alert('select action first!')">Apply</button>
                </div> 
                <?php } ?>
                
                <div class="col-md-2 col-6 hidden">
                    <button type="button" class="btn btn-secondary btn-block" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/reallocate-qrcode/'); ?>', '<?php echo get_phrase('reallocate_qrcode'); ?>')">Reallocate QRcode</button>
                </div>                 
                
                </div>
                    <table id="basic-datatable-0" class="vyapari_tables table-responsive-xl table-responsive-lg table-responsive-md table-responsive table table-striped " data-page-length="2000" width="100%"> <!--nowrap-->
                        <thead>
                            <tr style="background-color: #313a46; color: #ababab;">
                                <th width="5%"><input type="checkbox" class="check_all" name="check_all" value="1"></th>
                                <th width="10%"><?php echo get_phrase('sr_no'); ?></th>
                                <th width="20%"><?php echo get_phrase('pass_no'); ?></th>
                                <th class="hidden" width="20%"><?php echo get_phrase('vyapari_name'); ?></th>
                                <th class="hidden" width="20%"><?php echo get_phrase('vyapari_phone'); ?></th>
                                <th width="10%"><?php echo get_phrase('status'); ?></th>
                                <th width="25%"><?php echo get_phrase('notes'); ?></th>
                                <th width="30%"><?php echo get_phrase('Other Details'); ?></th>
                                <th width="10%"><?php echo get_phrase('IN'); ?></th>
                                <th width="15%"><?php echo get_phrase('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1; 
                                foreach($vyapari_qrcodes as $row){
                                $notes = $this->db->where('qrcode_id', $row['qrcode_id'])->get('app_qrcode_complaints')->result_array();
                            ?>
                                <tr>
                                    <td>
                                        <?php if($row['status'] != 'exit'){ ?>
                                        <input type="checkbox" class="complaints_checkbox" name="complaints_checkbox[]" value="<?php echo $row['qrcode_id']; ?>">
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $i++;; ?></td>
                                    <td><?php echo $row['qrcode']; ?></td>
                                    <td class="hidden"><?php echo $vyapari['name']; ?></td>
                                    <td class="hidden"><?php echo $vyapari['phone']; ?></td>
                                    <td>
                                        <?php if($row['status'] == 'block'){ ?>
                                             <b><span class="text-danger">Blocked</span></b>
                                        <?php }elseif($row['status'] == 'unblock'){ ?>
                                             <b><span class="text-warning">Active</span></b>
                                        <?php }elseif($row['status'] == 'exit'){ ?>
                                             <b><span class="text-success">Exit</span></b>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php $x=1; if($row['status'] != 'exit'){ foreach($notes as $row1){ ?>
                                            <div>
                                                <?php echo $x++.'. '.$row1['status'].':-'.$row1['notes']; ?>
                                                <br>
                                                <b>Date : <?php echo $row1['timestamp']; ?></b>
                                                <hr style="margin:5px;">
                                            </div>
                                        <?php }} ?>
                                    </td>
                                    <td><label>Receipt No : <?php echo $row['receipt_no']; ?></label>
                                        <?php $bk_n = $this->db->get_where('app_broker', array('id' => $row['broker_id']))->row()->applicant_name ?>
                                        <?php $gw_n = $this->db->get_where('app_gwala', array('id' => $row['gwala_id']))->row()->applicant_name ?>
                                        <br> <label>Broker Name : <?php echo $bk_n; ?></label>
                                        <br> <label>Gawala Name : <?php echo $gw_n; ?></label>
                                    </td>
                                    <td><?php echo $row['timestamp']; ?></td>
                                    <td class="options_buttons">
                                        <?php if(access('manage_pass_button')){ ?>
                                        <?php if($row['status'] == 'unblock'){ ?>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/complaint-qrcode/'.$row['qrcode_id'].'/block'); ?>', '<?php echo get_phrase('block_qrcode'); ?>')"><i class="mdi mdi-block-helper" style="font-size: 12px;"></i> <?php echo get_phrase('block'); ?></button>
                                        <?php }elseif($row['status'] == 'block'){ ?>

                                            <button type="button" class="btn btn-sm btn-info" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/complaint-qrcode/'.$row['qrcode_id'].'/unblock'); ?>', '<?php echo get_phrase('unblock_qrcode'); ?>')"><i class="mdi mdi-check-circle" style="font-size: 15px;"></i>  <?php echo get_phrase('unblock'); ?></button>                                        <?php }elseif($row['status'] == 'exit'){ ?> 
                                             
                                             <b><span class="text-success">Scanned at <?= $row['exit_date'] ?></span></b>
                                             <b><span class="text-success">Exit Gate No: <?= $row['exit_gate'] ?></span></b>
                                            <?php $user_exit_by = $this->db->select('name')->from('users')->where('id', $row['exit_by'])->get()->row(); ?>
                                            <br><b><span class="text-success">Exit By: <?= $user_exit_by->name ?></span></b>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>              
            </div>
        </div>
    </div>
</div>

<style>
.vyapari_qrcodes .dt-buttons.btn-group {
   position: absolute;
}

.dataTables_length {
    display: none;
}   
.tclass1 td {
        padding:0px 40px 0px 0px;
    }

        .tclass1 span {
    font-weight: bold;
    color: #363636;
}
    
    .tclass1 p{
        margin-bottom: 10px;
    }
    a.printbtn {
    position: absolute;
    right: 20px;
    bottom: 30px;
}
.alignToTitle {
    margin-left: 11px;
}
.one {
    max-width: 10%;
}
/*.row.totaldiv {
    position: absolute;
    left: 20px;
    right: 0;
    
    z-index: 1;
}*/


div#basic-datatable-0_filter input {
   z-index: 9;
   position: relative;
}

@media (max-width: 767px){
 
    a.printbtn {
    display: grid;
    position: initial;
}
.vpdimg {
    display: grid;
    justify-content: center;
}
h4.vyapdet {
    text-align: center;
    margin-bottom: 20px;
}
.alignToTitle {
    float: none;
}
h3#qrtotal {
    text-align: center;
}

.col-md-3.serhbox {
    margin-bottom: 20px;
}

.col-md-2.apbtn {
    margin-bottom: 20px;
}
.row.totaldiv{
    position: initial;
}
.wrapper {
    padding-top: 0;
}
}


</style>
<script>

    $(document).ready(function(){
        $('#actionSelect').change(function(){
            var selectedOption = $(this).find('option:selected');
            var clickEventValue = selectedOption.attr('data-event');
            $('#applyButton').attr('onclick', clickEventValue);
        });
    });


    $("body").on('change', '.check_all', function() {
    if(this.checked)
    {
        $('.complaints_checkbox').attr('checked','checked');
    }
    else
    {
         $('.complaints_checkbox').removeAttr('checked');
    }
});

$(document).ready(function () {
    $('#basic-datatable-0').DataTable({
       "order": [],
		dom: 'lBfrtip',
		buttons: [
		    {
                extend: 'csvHtml5',
                filename: 'blocked-passes', 
                text: 'Export',
                className: 'btn-sm btn-secondary btn-data-export',
                exportOptions: {
                    columns: [ 1, 2, 3, 4, 5, 6, 7 , 8]
                }                    
            }
        ],       
        "columnDefs": [
            { "orderable": false, "targets": 0 },
            { "orderable": false, "targets": 1 },
            { "orderable": false, "targets": 2 },
            { "orderable": false, "targets": 3 },
            { "orderable": false, "targets": 4 },
            { "orderable": false, "targets": 5 },
            { "orderable": false, "targets": 6 },
            { "orderable": false, "targets": 7 },
            { "orderable": false, "targets": 8 },

        ],        
    });
});
</script>
