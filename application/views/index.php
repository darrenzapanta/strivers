


      <!-- page content -->
      <div class="right_col" role="main">

        <br />
        <div class="">

          <div class="row top_tiles">
            <?php foreach ($sim as $sim_item): ?>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fa  fa-quote-right"></i>
                  </div>
                  <div name="currentbalance" class="currentbalance count"><?php echo $sim_item->current_balance; ?></div>

                  <h3><?php echo $sim_item->global_name; ?></h3>
                  <p>Current Balance</p>
                </div>
              </div>              
            <?php endforeach ?>
          </div>

          <div class="row">
            <div class="col-md-9">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Transaction Summary</h2>
                  <div class="filter">
                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                    </div>
                  </div>                  
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="demo-container" style="height:280px">
                      <div id="placeholder33x" class="demo-placeholder"></div>
                    </div>
                    <div class="tiles">
                      <div class="col-md-4 tile">
                        <span>Total Revenue</span>
                        <h1 id="revenue"></h1>
                        <span class="sparkline22 graph" style="height: 160px;">
                                        <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                    </span>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>



          

        <!-- footer content -->

      </div>
      <!-- /page content -->
    </div>


  </div>

  <div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
  </div>


  <!-- daterangepicker -->
  <script type="text/javascript" src="<?php echo base_url(); ?>js/moment/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/datepicker/daterangepicker.js"></script>
  <!-- chart js -->
  <script src="<?php echo base_url(); ?>js/chartjs/chart.min.js"></script>
  <!-- sparkline -->
  <script src="<?php echo base_url(); ?>js/sparkline/jquery.sparkline.min.js"></script>


  <!-- flot js -->
  <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.pie.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.orderBars.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.time.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/date.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.spline.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.stack.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/curvedLines.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>js/flot/jquery.flot.resize.js"></script>

  <!-- pace -->
  <script src="<?php echo base_url(); ?>js/pace/pace.min.js"></script>
  <!-- flot -->

  <script src="<?php echo base_url(); ?>js/numeral/numeral.min.js"></script>
  <script type="text/javascript">
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

    //generate random number for charts

    function updateChart(tck, d3){
      var label = "Transaction";
      var options = {
        grid: {
          show: true,
          aboveData: true,
          color: "#3f3f3f",
          labelMargin: 10,
          axisMargin: 0,
          borderWidth: 0,
          borderColor: null,
          minBorderMargin: 5,
          clickable: true,
          hoverable: true,
          autoHighlight: true,
          mouseActiveRadius: 100
        },
        series: {
          lines: {
            show: true,
            fill: true,
            lineWidth: 2,
            steps: false
          },
          points: {
            show: true,
            radius: 4.5,
            symbol: "circle",
            lineWidth: 3.0
          }
        },
        legend: {
          position: "ne",
          margin: [0, -25],
          noColumns: 0,
          labelBoxBorderColor: null,
          labelFormatter: function(label, series) {
            // just add some space to labes
            return label + '&nbsp;&nbsp;';
          },
          width: 40,
          height: 1
        },
        colors: chartColours,
        shadowSize: 0,
        tooltip: true, //activate tooltip
        tooltipOpts: {
          content: "%s: %y.0",
          xDateFormat: "%d/%m",
          shifts: {
            x: -30,
            y: -50
          },
          defaultTheme: false
        },
        yaxis: {
          min: 0,
          minTickSize: 1
        },
        xaxis: {
          ticks: tck,
        }
      };
      var plot = $.plot($("#placeholder33x"), [{
        label: label,
        data: d3,
        lines: {
          fillColor: "rgba(150, 202, 89, 0.12)"
        }, //#96CA59 rgba(150, 202, 89, 0.42)
        points: {
          fillColor: "#fff"
        }
      },
      ], options);      
    }
  </script>
  <!-- /flot -->
  <!--  -->
  
  <!-- -->
  <!-- datepicker -->
  <script type="text/javascript">
    $(document).ready(function() {
      numeral.language('en', {
        delimiters: {
            millions: ',',
            thousands: ',',
            decimal: '.'
        },
        abbreviations: {
            thousand: 'k',
            million: 'm',
            billion: 'b',
            trillion: 't'
        },
        currency: {
            symbol: '₱'
        }
        });
      numeral.language('en');
        var path = "<?php echo site_url(); ?>";
        var app = "TransactionController";
        var d1 = moment().startOf('month').format('MMMM D, YYYY'); 
        var d2 = moment().endOf('month').format('MMMM D, YYYY');
        $.ajax({
          method: 'POST',
            url: path + "/" + app + "/graphSales",
            cache: false,
            data: {date1: d1, date2: d2},
            async:false,
            success: function (data){
              updateChart(data['tick'], data['data']);
              $('#revenue').html(numeral(data['revenue']).format('$0,0.00'));
            },
            error: function (data){

            } 
        }); 



      $('div[name="currentbalance"]').each(function( index ) {
        var text = $( this ).text();

        $(this).html(numeral(text).format('$0,0.00'));
      });      

      var cb = function(start, end, label) {

        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
      }

      var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2016',
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        
        separator: ' to ',
        locale: {
          format: 'MM/DD/YYYY',
          applyLabel: 'Submit',
          cancelLabel: 'Clear',
          fromLabel: 'From',
          toLabel: 'To',
          customRangeLabel: 'Custom',
          daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          firstDay: 1
        }
      };
      $('#reportrange span').html(moment().startOf('month').format('MMMM D, YYYY') + ' - ' + moment().endOf('month').format('MMMM D, YYYY'));
      $('#reportrange').daterangepicker(optionSet1, cb);
      $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));

        var date1 = picker.startDate.format('MMMM D, YYYY');
        var date2 = picker.endDate.format('MMMM D, YYYY');
        $.ajax({
          method: 'POST',
            url: path + "/" + app + "/graphSales",
            cache: false,
            data: {date1: date1, date2: date2},
            async:false,
            success: function (data){
              updateChart(data['tick'], data['data']);
              $('#revenue').html(numeral(data['revenue']).format('$0,0.00'));
            },
            error: function (data){

            } 
        });  
      });
      $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
      });
      $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
      });
      $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
      });
      $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
      });
    });
  </script>
  <!-- /datepicker -->
</body>

</html>
