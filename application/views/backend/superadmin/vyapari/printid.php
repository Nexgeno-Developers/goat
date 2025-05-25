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
    width:20%;
    float:left;
}

.vyapari_coluom_one img
{
    
    float:right;
    margin-top:10px;
}
.vyapari_coluom_two
{
    width:80%;
    padding-left:20px;
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
       <div class="vyapari_coluom_one">
           <?= $vyapari['photo'] ? '<img width="146px" height="116px" src="uploads/vyapari_photo/'.$vyapari['photo']. '?' . time() . '">' : null; ?>
       </div> 
       
       <div class="vyapari_coluom_two">
           
           
                
                
           <p><b><span>Vyapari ID</span>: <?= vyapari_id($vyapari['vyapari_id']); ?></b></p>
           <p style="width:200px"><b><span>Name</span>:</b> <?= $vyapari['name']; ?></p>
           <p><b><span>Mob</span>:</b> <?= $vyapari['phone']; ?></p>
           <p><b><span>Loc</span>:</b> <?= $vyapari['locality']; ?></p>
           <p><b><span>State</span>:</b> <?= $vyapari['state']; ?></p>
           <img width="100px" height="100px" src="uploads/vyapari_qrcode/<?php echo $vyapari['vyapari_id']; ?>.png">
       </div>
        
    </div>
<div class="position:absolute; left:80px; top:150px"></div>

        
         </body>
</html>           
              