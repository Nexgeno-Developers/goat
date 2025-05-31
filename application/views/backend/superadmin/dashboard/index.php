

<!-- start page title -->
<div class="row ">
  <div class="col-xl-12 breadcrumes">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-home title_icon"></i> <?php echo get_phrase('dashboard'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->



<div class="dashboard_box">
<div class="row ">
    
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-6 pddleft_0">
                <div class="card card-stats two">
                     <a class="dashbox" href="reports/inward">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <img src="../assets/backend/images/arrow_icon1.svg" alt="">
                        </div>
                        <p class="card-category"><?php echo get_phrase('Inward Total Goat'); ?></p>
                        <h3 class="card-title"> 
                        <?php
                          echo $unblock;
                          ?>
              </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> Just Updated
                        </div>
                    </div>
                   </a>
                </div>
            </div>
            
                
            <div class="col-lg-4 col-md-4 col-sm-4 col-6 pl-md-1 pddright_0">
                <div class="card card-stats four">
                    <a class="dashbox" href="reports/outward">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <img src="../assets/backend/images/arrow_icon3.svg" alt="">
                        </div>
                        <p class="card-category"><?php echo get_phrase('Outward Total Goat'); ?></p>
                        <h3 class="card-title"> 
                        <?php
                          echo $exit
        
                          ?>
                          </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="fa fa-clock-o"></i> Just Updated
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            
                <div class="col-lg-4 col-md-4 col-sm-4 col-6 pl-md-1 pddleft_0">
                    <div class="card card-stats five">
                         <a class="dashbox" href="manage_vyapari"> 
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/arrow_icon7.svg" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Balance Total Goat'); ?> </p>
                            <h3 class="card-title"> 
                            <?php
                               echo $unblock - $exit;
                            ?>
                           </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Just Updated
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            
               
                <div class="col-lg-4 col-md-4 col-sm-4 col-6 pddright_0">
                    <div class="card card-stats three">
                        <a class="dashbox" href="reports/blocked">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/arrow_icon8.svg" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Pass Blocked'); ?>  </p>
                            <h3 class="card-title"> 
                            <?php
                              echo $block;
                              ?>
                            </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Just Updated
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                
                
                 <div class="col-lg-4 col-md-4 col-sm-4 col-6 pl-md-1 pddleft_0">
                    <div class="card card-stats one">
                         <a class="dashbox" href="manage_vyapari"> 
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/arrow_icon9.svg" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Registered Total Vyapari'); ?> </p>
                            <h3 class="card-title"> 
                            <?php
                               echo $vyapari;
                            ?>
                           </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Just Updated
                            </div>
                        </div>
                        </a>
                    </div>
                </div>

                 <div class="col-lg-4 col-md-4 col-sm-4 col-6 pl-md-1 pddright_0">
                    <div class="card card-stats six">
                         <a class="dashbox" href="manage_admins"> 
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/arrow_icon10.svg" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Staff and Members'); ?> </p>
                            <h3 class="card-title"> 
                            <?php
                               echo $active_admins;
                            ?>
                           </h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Just Updated
                            </div>
                        </div>
                        </a>
                    </div>
                </div>                
                


            
        </div>
        
    </div>
    
    <!--<div class="col-md-6">
       <div class="chart_box">
           <p>The graph is under maintenance</p>
       </div> 
    </div>--->
        
    <div class="col-md-12 mt-1">
                <div class="chart_box">
                  <div class="color_represent">
                    <div class="inward">
                        <p class="">Inward </p>
                        <div class="circle"></div>
                    </div>

                    <div class="outward ">
                        <p class="">Outward  </p>
                        <div class="circle1"></div>
                    </div>
                  </div>
            <canvas id="myChart"></canvas>
    </div>
    </div>

    <div class="col-md-12 mt-3">
                <div class="chart_box">
            <p>Goat In & Out Graph</p>
        <table class="table table-striped dt-responsive nowrap">
        	<thead>
        		<tr>
        		    <th>Sr. No.</th>
        			<th>Date</th>
        			<th>Inward</th>
        			<th>Outward</th>
        		</tr>
        	</thead>
        	<tbody id="chart-table-body">
        	</tbody>
        </table>                 
    </div>
    </div>
            
           
</div>

</div>

<script>
var currentDate = new Date();

var day = new Date().getDate(); //20;
var current_month = currentDate.getMonth() + 1;

var start_date =  <?php echo $startdate ?>;
var start_month = <?php echo $month ?>;
var daysInMonth = <?php echo $days ?>;

var animalin = <?php echo $aniamalin ?>;
var animalout = <?php echo $aniamalout ?>;



const yValuesIN = [];
const yValuesOut = []; 

const xValues = [];



if(current_month == start_month){
    for (let i = start_date; i <= day; i++) {
        xValues.push(i);
    }
} else {
    for (let i = start_date; i <= daysInMonth + 1; i++) {
        if(i !== daysInMonth + 1){
            xValues.push(i);
        } else {
           
          for (let j = 1; j <= day; j++) {
               xValues.push(j);
          }
              
           
        }
    }
}


for (var i = 0; i < xValues.length; i++) {
  var found = false;

  for (var j = 0; j < animalout.length; j++) {
    if (animalout[j]['DATE'] == xValues[i]) {
      animalout[j].sr_no = i + 1;
      found = true;
      break;
    }
  }

  if (!found) {
    animalout.push({ DATE: xValues[i].toString(), count: '0', sr_no: i + 1 });
  }
  
}


for (var i = 0; i < xValues.length; i++) {
  var found = false;

  for (var j = 0; j < animalin.length; j++) {
    if (animalin[j]['DATE'] == xValues[i]) {
      animalin[j].sr_no =i + 1;
      found = true;
      break;
    }
  }

  if (!found) {
    animalin.push({ DATE: xValues[i].toString(), count: '0', sr_no: i + 1 });
  }
  
}


animalin.sort(function(a, b) {
  var animalinA = parseInt(a.DATE);
  var animalinB = parseInt(b.DATE);
  return animalinA - animalinB;
});

animalout.sort(function(a, b) {
  var animaloutA = parseInt(a.DATE);
  var animaloutB = parseInt(b.DATE);
  return animaloutA - animaloutB;
});

animalin.sort(function(a, b) {
  var animalinA = parseInt(a.sr_no);
  var animalinB = parseInt(b.sr_no);
  return animalinA - animalinB;
});

animalout.sort(function(a, b) {
  var animaloutA = parseInt(a.sr_no);
  var animaloutB = parseInt(b.sr_no);
  return animaloutA - animaloutB;
});


//console.log(animalin);
//console.log(animalout);


for (var i = 0; i < animalin.length; i++) {
  var count = animalin[i].count;
  yValuesIN.push(count); 
}

for (var i = 0; i < animalout.length; i++) {
  var count = animalout[i].count;
  yValuesOut.push(count); 
}



new Chart("myChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{ 
      data: yValuesIN,
      borderColor: "#71357C", 
      fill: false
    }, { 
      data: yValuesOut,
      borderColor: "#95D0D5",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});

$(document).ready(function() {
    var today = new Date().getDate();
    for (var i = 0; i < xValues.length; i++) {

        var dayx = xValues[i];
        var labelMonthYear = (dayx >= 21) ? 'May 2025' : 'June 2025';

        // if (xValues[i] <= today) {
            var row = '<tr>' +
                '<td>' + (i + 1)  + '</td>' +
                '<td>' + xValues[i] + ' ' + labelMonthYear + '</td>' +
                '<td>' + yValuesIN[i] + '</td>' +
                '<td>' + yValuesOut[i] + '</td>' +
                '</tr>';
            $('#chart-table-body').append(row);
        // }
    }
});
</script>


<script>
$(document).ready(function() {
  initDataTable("expense-datatable");
});

$(".widget-flat").mouseenter(function() {
  var id = $(this).attr('id');
  $('#'+id+'_list').show();
}).mouseleave(function() {
  var id = $(this).attr('id');
  $('#'+id+'_list').hide();
});
</script>



