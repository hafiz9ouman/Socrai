
<?php $__env->startSection('content'); ?>


<style>
.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}
.border-left-danger {
    border-left: .25rem solid #e74a3b!important;
}
.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}
.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}
    .impor {
    color: #ee8322;
    /*border: 1px solid;*/
    /*padding: 4px 7px;*/
}
.zomi {
    color: blue;
    /*border: 1px solid;*/
    /*padding: 4px 7px;*/
}
.priz {
    /* border: 1px solid;*/
    /*padding: 4px 7px;*/
}
.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}
.card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.no-gutters {
    margin-right: 0;
    margin-left: 0;
}
.text-xs {
    font-size: .7rem;
}
.text-primary {
    color: #4e73df!important;
}
.font-weight-bold {
    font-weight: 700!important;
}
.text-gray-800 {
    color: #5a5c69!important;
}
.shadow {
    -webkit-box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;
}
.card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e3e6f0;
    border-radius: .35rem;
}
.text-gray-300 {
    color: #dddfeb!important;
}
</style>


<?php $curr=Config::get("constants.currency"); ?>

<div class="app-title">

<ul class="app-breadcrumb breadcrumb">
<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
</ul>
</div>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                      <a href="#">
                      <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <a href="<?php echo e(url('tribes')); ?>">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tribes</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                  <?php
                                    $tribe_count = DB::table('tribes')->count();
                                  ?>
                                  <?php echo e($tribe_count); ?>

                              </div>
                            </a>
                            </div>
                            <div class="col-auto">
                              <i class="fa fa-users fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <!-- <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Daily Visitors</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">23</div>
                            </div>
                            <div class="col-auto">
                              <i class="fa fa-users fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->

                    <!-- <a href="<?php echo e(url('users')); ?>"> -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <a href="<?php echo e(url('users')); ?>">

                              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Users</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                   <?php
                                    $user_count = DB::table('users')->where('user_role','!=','1')->count();
                                  ?>
                                  <?php echo e($user_count); ?>

                              </div>
                            </div>
                            </a>

                            <div class="col-auto">
                              <i class="fa fa-users fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <!-- </a> -->
                    <div class="col-xl-3 col-md-6 mb-4">
                      <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                          <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                              <a href="<?php echo e(url('topics')); ?>">
                              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Topics</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">
                                   <?php
                                    $topic_count = DB::table('topics')->count();
                                  ?>
                                  <?php echo e($topic_count); ?>

                              </div>
                            </a>
                            </div>
                            <div class="col-auto">
                              <i class="fa fa-users fa-2x text-gray-300"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
          
                </div>





<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script type="text/javascript" src="<?php echo e(url('public/backend/js/plugins/chart.js')); ?>"></script>

<script type="text/javascript">
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Properties"
	},
	axisY: {
		title: "Medals"
	},
	legend: {
		cursor:"pointer",
		itemclick : toggleDataSeries
	},
	toolTip: {
		shared: true,
		content: toolTipFormatter
	},
	data: [{
		type: "bar",
		showInLegend: true,
		name: "Sales",
		color: "#3094d1",
		dataPoints: [
			{ y: 243, label: "Sunday" },
			{ y: 236, label: "Saturday" },
			{ y: 243, label: "Friday" },
			{ y: 273, label: "Thursday" },
			{ y: 269, label: "Wednesday" },
			{ y: 196, label: "Tuesday" },
			{ y: 1118, label: "Monday" }
		]
	},
	{
		type: "bar",
		showInLegend: true,
		name: "Rents",
		color: "#ac3939",
		dataPoints: [
			{ y: 212, label: "Sunday" },
			{ y: 186, label: "Saturday" },
			{ y: 272, label: "Friday" },
			{ y: 299, label: "Thursday" },
			{ y: 270, label: "Wednesday" },
			{ y: 165, label: "Tuesday" },
			{ y: 896, label: "Monday" }
		]
	}]
});
chart.render();

function toolTipFormatter(e) {
	var str = "";
	var total = 0 ;
	var str3;
	var str2 ;
	for (var i = 0; i < e.entries.length; i++){
		var str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ;
		total = e.entries[i].dataPoint.y + total;
		str = str.concat(str1);
	}
	str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
	str3 = "<span style = \"color:Tomato\">Total: </span><strong>" + total + "</strong><br/>";
	return (str2.concat(str)).concat(str3);
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>

<script type="text/javascript">
var data = {
labels: ["January", "February", "March", "April", "May","June","July", "Auguest", "September", "October", "November", "December"],
datasets: [
{
label: "Plan1",
fillColor: "rgba(220,220,220,0.2)",
strokeColor: "rgba(220,220,220,1)",
pointColor: "rgba(220,220,220,1)",
pointStrokeColor: "#fff",
pointHighlightFill: "#fff",
pointHighlightStroke: "rgba(220,220,220,1)",
data: [65, 59, 80, 81, 56,23,45,109,68,89,23,100]
},
{
label: "Plan2",
fillColor: "rgba(151,187,205,0.2)",
strokeColor: "rgba(151,187,205,1)",
pointColor: "rgba(151,187,205,1)",
pointStrokeColor: "#fff",
pointHighlightFill: "#fff",
pointHighlightStroke: "rgba(151,187,205,1)",
data: [28, 48, 40, 19, 86, 80, 81, 56,23,45,56,90]
}
]
};
var pdata = [
{
value: 200,
color: "#46BFBD",
highlight: "#5AD3D1",
label: "Upcoming"
},
{
value: 112,
color:"#F7464A",
highlight: "#FF5A5E",
label: "In-Progress"
}

]

var ctxl = $("#lineChartDemo").get(0).getContext("2d");
var lineChart = new Chart(ctxl).Line(data);

var ctxp = $("#pieChartDemo").get(0).getContext("2d");
var pieChart = new Chart(ctxp).Pie(pdata);
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Socrai\resources\views/admin/dashboard/home.blade.php ENDPATH**/ ?>