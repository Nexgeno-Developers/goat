

<!-- start page title -->
<div class="row ">
  <div class="col-xl-12 breadcrumes">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('dashboard'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->



<div class="dashboard_box">
<div class="row ">
    
    <div class="col-md-6">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="card card-stats three">
                     <a class="dashbox" href="reports/inward">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <img src="../assets/backend/images/icon-3.png" alt="">
                        </div>
                        <p class="card-category"><?php echo get_phrase('Total Goat Inward'); ?></p>
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
            
                
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <div class="card card-stats four">
                    <a class="dashbox" href="reports/outward">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <img src="../assets/backend/images/icon-4.png" alt="">
                        </div>
                        <p class="card-category"><?php echo get_phrase('Total Goat Outward'); ?></p>
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
            
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card card-stats one">
                         <a class="dashbox" href="manage_vyapari"> 
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/icon-1.png" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Total Balance Goat'); ?> </p>
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
            
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card card-stats two">
                        <a class="dashbox" href="reports/blocked">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/icon-2.png" alt="">
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
                
                
                 <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card card-stats one">
                         <a class="dashbox" href="manage_vyapari"> 
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <img src="../assets/backend/images/icon-1.png" alt="">
                            </div>
                            <p class="card-category"><?php echo get_phrase('Total Vyapari Registered'); ?> </p>
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
                


            
        </div>
        
    </div>
    
    <!--<div class="col-md-6">
       <div class="chart_box">
           <p>The graph is under maintenance</p>
       </div> 
    </div>--->
        
    <div class="col-md-6">
                <div class="chart_box">
            <canvas id="myChart"></canvas>
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
            
           
            
            
           
            
          <div class="col-xl-4 hidden">
            <div class="card bg-primary">
              <div class="card-body">
                <h4 class="header-title text-white mb-2"><?php echo get_phrase('todays_attendance'); ?></h4>
                <div class="text-center">
                  <h3 class="font-weight-normal text-white mb-2">
                    <?php echo $this->crud_model->get_todays_attendance(); ?>
                  </h3>
                  <p class="text-light text-uppercase font-13 font-weight-bold"><?php echo $this->crud_model->get_todays_attendance(); ?> <?php echo get_phrase('students_are_attending_today'); ?></p>
                  <a href="<?php echo route('attendance'); ?>" class="btn btn-outline-light btn-sm mb-1"><?php echo get_phrase('go_to_attendance'); ?>
                    <i class="mdi mdi-arrow-right ml-1"></i>
                  </a>
    
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-body">
                <h4 class="header-title"><?php echo get_phrase('recent_events'); ?><a href="<?php echo route('event_calendar'); ?>" style="color: #6c757d;"><i class = "mdi mdi-export"></i></a></h4>
                <?php include 'event.php'; ?>
              </div>
            </div>
          </div>
</div>

</div>

<div class="row hidden">
  <div class="col-xl-12">
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title mb-3"><?php echo get_phrase('accounts_of'); ?> <?php echo date('F'); ?> <a href="<?php echo route('invoice'); ?>" style="color: #6c757d"><i class = "mdi mdi-export"></i></a></h4>
            <?php include 'invoice.php'; ?>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="header-title mb-3"> <?php echo get_phrase('expense_of'); ?> <?php echo date('F'); ?> <a href="<?php echo route('expense'); ?>" style="color: #6c757d"><i class = "mdi mdi-export"></i></a></h4>
            <?php include 'expense.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script>
var currentDate = new Date();

var day = 20;
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
      borderColor: "#722bfb", 
      fill: false
    }, { 
      data: yValuesOut,
      borderColor: "#3fdd4f",
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
        if (xValues[i] <= today) {
            var row = '<tr>' +
                '<td>' + (i + 1)  + '</td>' +
                '<td>' + xValues[i] + ' June 2024</td>' +
                '<td>' + yValuesIN[i] + '</td>' +
                '<td>' + yValuesOut[i] + '</td>' +
                '</tr>';
            $('#chart-table-body').append(row);
        }
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
