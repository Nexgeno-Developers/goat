<?php 
   $vyapari = $this->db->where('id', $vyapari_id)->get('users')->row_array();
?>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title><?= $vyapari['id']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css">

    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />-->
<style>
p
{
    font-size:10px;
}
.vyapari_coluom_one
{
    width:100%;
}

.vyapari_coluom_one img
{
    width:80px;
    margin-top:0px;
    margin-bottom:0px;
}
.vyapari_coluom_two
{
    width:100%;
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

.signature_img
{
    width:60px;
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
    <!--position:absolute; left:140px; top:385px; transform: rotate(90deg);-->
    <div style="position:relative; left:0px; top:40px; width:240px; margin-left:auto; margin-right:auto; display:block;border:1px solid #ccc3;">
        <div>
      <img width="240px" height="auto" src="uploads/top_image.png?<?php echo time(); ?>">
      </div>

      <p style="text-align:center; font-size:16px; font-weight:bold; padding-top:0px;">Deonar Abattoir</p>
       <div class="vyapari_coluom_one" style="text-align:center;">
            <?= file_exists('uploads/users/'.$vyapari['id'].'.jpg') ? '<img src="uploads/users/'.$vyapari['id'].'.jpg?'.time().'">' : '<img src="uploads/emp_photo/logo.png?'.time().'">'?>
       </div> 
       
       <div style="font-size:14px; margin-top:-5px; font-weight:700; text-align:center;"><?= $vyapari['name']; ?></div>
       <div style="font-size:10px; margin-top:-5px; font-weight:600; text-align:center; text-transform:capitalize;"><?= $vyapari['role_type']; ?></div>
       
       
       
       <div class="vyapari_coluom_two" style="margin-top:10px; padding-left:20px; padding-bottom:5px; padding-right:20px; text-align:left">
           
           
                
                
           <table>
               <tr style="padding:0px;">
                   <td style="font-size:10px; width:32px; padding:0px"><b>ID NO</b></td>
                   <td style="font-size:10px; padding:0px"><b>: </b></td>
                   <td style="font-size:10px; padding:0px"><b> <?= $vyapari['id']; ?></b></td>
               </tr>
               
               <?php /*<tr style="padding:0px;">
                   <td style="font-size:10px; width:32px; padding:0px">Email</td>
                   <td style="font-size:10px; padding:0px">: </td>
                   <td style="font-size:10px; padding:0px"> <?= $vyapari['email']; ?></td>
               </tr >
               
               */?>
               
               <tr style="padding:0px;">
                   <td style="font-size:10px; width:32px; padding:0px">Place</td>
                   <td style="font-size:10px; padding:0px">: </td>
                   <td style="font-size:10px; padding:0px"> <?= !empty($vyapari['address']) ? htmlspecialchars($vyapari['address']) : '-' ?></td>
               </tr>
               
               <tr style="padding:0px;">
                   <td style="font-size:10px; width:32px; padding:0px">Mob</td>
                   <td style="font-size:10px; padding:0px">: </td>
                   <td style="font-size:10px; padding:0px"> <?= !empty($vyapari['mobile']) ? $vyapari['mobile'] : '-' ?></td>
               </tr>
           </table>
           <!--<p style="padding-top:10px;"><b><span>Emerg No &nbsp;</span>:</b> ‪+91 9773375525‬ <br> &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;  &nbsp; &nbsp;‪+91 9029075525‬</p>-->
           
  <div style="margin-left:55%; margin-top:-10px'">
           <img class="signature_img" src="uploads/signature.png" style="padding-top:20px; margin-left:30px;">
           <p style="padding-top:0px;padding-bottom:5px; text-align:left; margin-top:-2px;">Signature or Stamp  </p>
           </div>
           
       </div>
       
        <div>
      <img width="240px" height="" src="uploads/bottom_icons1.png?<?php echo time(); ?>">
      </div>
        
    </div>
<div class="position:absolute; left:80px; top:150px"></div>

        
         </body>
</html>