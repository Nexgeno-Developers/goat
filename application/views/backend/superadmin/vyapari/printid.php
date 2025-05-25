<?php 
   $vyapari = $this->db->where('vyapari_id', $vyapari_id)->get('app_vyapari')->row_array();
?>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title><?= vyapari_id($vyapari['vyapari_id']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css">

    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />-->
<style>

.vyapari_coluom_one
{
    width:23%;
    float:left;
}

.vyapari_coluom_one img
{
    
    float:right;
    margin-top:5px;
}
.vyapari_coluom_two
{
    width:77%;
    padding-left:10px;
    float:left;
}

.vyapari_coluom_two p
{
    margin-bottom:0px;
}
.botton_border
{
    border-bottom:5px solid #f00;
    width:380px;
    text-align:center;
    padding-bottom:5px;
}
.font16
{
    font-size:12px;
    line-height:17px;
}
td, th {
        padding:0px 8px 8px 8px;
    }
    .head{
        text-align: center;
    }
    
    .tclass span{
        font-weight: 600;
    }

@page { margin: 0px; }
</style>
</head>
<body>
    
    <div style="position:absolute; left:140px; top:385px; transform: rotate(90deg)">
        <div>
      <img width="350px" height="30px" src="uploads/heading_images_bg.png?<?php echo time(); ?>" style="position:absolute; left:-25px; bottom:130px; top:-35px;">
      </div>
       <div class="vyapari_coluom_one" style="margin-left:-30px;">
           <?= $vyapari['photo'] ? '<img width="146px" height="116px" src="uploads/vyapari_photo/'.$vyapari['photo']. '?' . time() . '">' : null; ?>
           <p style=" font-size:12px; padding-top:125px; margin-left:10px;"><b><span>Vyapari No</span>:</b> <?= vyapari_id($vyapari['vyapari_id']); ?></p>
       </div> 
       
       <div class="vyapari_coluom_two">
           
           
                
                
           
           <p class="font16" style="width:200px"><b><span>Name</span>:</b> <?= $vyapari['name']; ?></p>
           <p class="font16" ><b><span>Mob</span>:</b> <?= $vyapari['phone']; ?></p>
           <p class="font16" ><b><span>Loc</span>:</b> <?= $vyapari['locality']; ?></p>
           <p class="font16" ><b><span>State</span>:</b> <?= $vyapari['state']; ?></p>
           <img style="margin-top:5px; margin-left:-7px;" width="75px" height="75px" src="uploads/vyapari_qrcode/<?php echo $vyapari['vyapari_id']; ?>.png">
       </div>
        
    </div>
<div class="position:absolute; left:80px; top:150px"></div>

        
         </body>
</html>