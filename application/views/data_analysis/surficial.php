<script type="text/javascript" src="/js/dewslandslide/data_analysis/surficial_level.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/surficial.css">
<div id="page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header" id="header-site">Surficial Overview</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class=""></i> Search Tool</h3>
          </div>
          <div class="panel-body">
            <table class="table" id="searchtool" >
              <tr>
                <th> Site: </th>
                <td><select class="form-control"  name="sitegeneral" id="sitegeneral" style=" width: auto;" ></td>
              </tr>
              <tr class="datetable">
                <th class="datetable"> Date: </th>
                <td class="datetable">  <div id="reportrange" class="pull-left form-control cols-xs-7" style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 226.22222px;" ;margin-bottom: 10px;">
                  <i class=""></i>&nbsp;
                  <span id="dateAnnotation"></span> <b class="caret"></b>
                </td>
              </tr>
              <tr>
                <th></th>
                <td> <input id="submit"  type="button" value="Submit"  style=" width: 226.22222px;" ></td>
              </tr>

              <tr class="crack_id_form">
                <th><br><br>Crack:</th>
                <td>Select Crack ID for Surficial Analysis Graph<br> 
                 <select class="form-control"  name="crackgeneral" id="crackgeneral" style=" width: auto;" placeholder="Select"></td>
                 </tr>
               </table>
             </div>
           </div>
         </div>
         <div class="col-lg-8" id="analysis_charts">
          <div class="panel-heading">
            <ul class="nav nav-tabs" role="tablist">
              <li class="active">
                <a class="nav-link active" data-toggle="tab" href="#graph1" role="tab" aria-expanded="false"><i class=""></i> Velocity Analysis Graph </a>
              </li>
              <li class="nav-item" >
                <a class="nav-link active" data-toggle="tab" href="#graph2" role="tab"><i class=""></i> Displacement Analysis Graph </a>
              </li>
            </ul>
          </div>
          <div class="panel panel-default">
            <div class="tab-content">
              <div class="tab-pane fade in active" id="graph1" role="tabpanel">
                <div id="analysisVelocity" ></div>
              </div>
              <div class="tab-pane " id="graph2" role="tabpanel"> 
                <div id="analysisDisplacement" ></div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="panel-heading" >
            <div id="alert_div"></div>
            <ul class="nav nav-tabs" role="tablist">
              <li class="active">
                <a class="nav-link active" data-toggle="tab" href="#graphS1" role="tab" aria-expanded="false"><i class=""></i> Surficial Measurement  </a>
              </li>
              <li class="nav-item" >
                <a class="nav-link active" data-toggle="tab" href="#graphS2" role="tab"><i class=""></i> Surficial Measurement Graph </a>
              </li>
              <li class="nav-item" >
                <a class="nav-link active" data-toggle="tab" href="#graphS3" role="tab"><i class=""></i> Surficial Measurement Form </a>
              </li>
              <li class="nav-item" >
                <a class="nav-link active" data-toggle="tab" href="#graphS4" role="tab"><i class=""></i> Piezometer </a>
              </li>
            </ul>
          </div>
          <div class="panel panel-default">
            <div class="tab-content">
              <div class="tab-pane fade in active" id="graphS1" role="tabpanel">
              </div>
              <div class="tab-pane " id="graphS2" role="tabpanel"> 
                <div id="ground_graph" ></div>
              </div>
              <div class="tab-pane " id="graphS3" role="tabpanel"> 
                <div id="ground_graph" ></div>
              </div>
              <div class="tab-pane " id="graphS4" role="tabpanel"> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="errorMsg" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <p > <h4 style="text-align: center;"> Please Select Site....</h4></p>
            </div>
          </div>
        </div>
      </div>
