
<!doctype html>
<html lang="en">
<head>

    <link rel="stylesheet" href="js/development-bundle/themes/base/jquery.ui.all.css">
	<script src="js/development-bundle/jquery-1.10.2.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>
    <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<title>LSB Change Plot</title>
    <link href='http://fonts.googleapis.com/css?family=Lato|Droid+Serif|Open+Sans' rel='stylesheet' type='text/css'>
    <style type="text/css">
		.myLSBGraph .dygraph-legend > span.highlight { border: 1px solid grey; }
        
    </style>
    <style type="text/css">
    #lsb-change-canvas .dygraph-label {
      /* This applies to the title, x-axis label and y-axis label */
      font-family: 'Lato', sans-serif;
    }
    #lsb-change-canvas .dygraph-title {
      /* This rule only applies to the chart title */
      font-family: 'Droid Serif', serif;  /* color, delta-x, delta-y, blur radius */
    }
    #lsb-change-canvas .dygraph-ylabel {
      /* This rule only applies to the y-axis label */
      font-family: 'Lato', sans-serif;  /* (offsets are in a rotated frame) */
    }
    </style>
	
</head>
<body>
    <script type='text/javascript'>
    
    function JSON2CSV(objArray) {
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

		var str = '';
		var line = '';

		if ($("#labels").is(':checked')) {
			var head = array[0];
			if ($("#quote").is(':checked')) {
				for (var index in array[0]) {
					var value = index + "";
					line += '"' + value.replace(/"/g, '""') + '",';
				}
			} else {
				for (var index in array[0]) {
					line += index + ',';
				}
			}

			line = line.slice(0, -1);
			str += line + '\r\n';
		}

		for (var i = 0; i < array.length; i++) {
			var line = '';

			if ($("#quote").is(':checked')) {
				for (var index in array[i]) {
					var value = array[i][index] + "";
					line += '"' + value.replace(/"/g, '""') + '",';
				}
			} else {
				for (var index in array[i]) {
					line += array[i][index] + ',';
				}
			}

			line = line.slice(0, -1);
			str += line + '\r\n';
		}
		return str;
	}

    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var column_plot_range;
    var roll_period = 48;
    
    function showLSBChange(frm) {
		showLSBChangeGeneral(frm, 'lsb-change-canvas');
	}

    function showLSBChangeGeneral(frm, e) {
	    xmlhttp.abort();
        var target = document.getElementById(e);
		var spinner = new Spinner().spin(target);
		//target.appendChild(spinner.el);
	  
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var datajson = xmlhttp.responseText;
                
                if (datajson == ""){
                    spinner.stop();
                    alert("No data retrieved. Please check input values.");
                    return;
                }
                var node_vel_data = JSON2CSV(datajson);
                
                g2 = new Dygraph(
                        target,
                        node_vel_data,
                        {
                            title: "LSB Change Plot for " + frm.sites.value.toUpperCase() + " " + frm.node.value,
                            ylabel: "LSB Velocity (LSB/6hours)",
                            labels: ["Timestamp","X","Y","Z"],
                            strokeWidth: 1.5,
                            
                            labelsDivWidth: 300,
                            rightgap: 500,
                            legend: "always",
                            labelsDivStyles: {
                                'text-align': 'right',
                                'font-family': 'Lato',
                                'background': 'none',
                                'height': '20px',
                            },
                            
                            highlightSeriesOpts: {
                              strokeWidth: 3,
                              strokeBorderWidth: 1,
                              highlightCircleSize: 5,
                            },
                            fillGraph: true,
                            
                            drawCallback: function(me, initial) {
								column_plot_range = me.xAxisRange();
                                roll_period = me.rollPeriod();
								
							},
                            
                            width: 750,
                            height: 500,
                            showRoller: true,
                            dateWindow: column_plot_range,
                            rollPeriod: roll_period,
                            colors: ['#284785', '#EE1111', '#006600'],
                            
                            underlayCallback: function(canvas, area, g2) {
                            
                                var c0 = g2.toDomCoords(g2.getValue(0,0), 0);
                                
                                canvas.fillStyle = '#FFB2B2';
                                canvas.fillRect(area.x, area.y, area.w, area.h);
                                
                                var c1 = g2.toDomCoords(g2.getValue(0,0), 1);
                                canvas.fillStyle = '#FFFFCC';
                                canvas.fillRect(area.x, c1[1], area.w, 2*(c0[1]-c1[1]));
                            
                                var c2 = g2.toDomCoords(g2.getValue(0,0), 0.25);
                                canvas.fillStyle = '#D1FFD1';
                                canvas.fillRect(area.x, c2[1], area.w, 2*(c0[1]-c2[1]));
                            },
                        }// options
                    );
                
            }
	    }
        
        var url = "ajax/getLsbChangeFromPurged.php?site=" + frm.sites.value + "&node=" + frm.node.value;
        xmlhttp.open("GET",url,true);
        xmlhttp.send();
	}
    
	</script>
</body>
<form>
<p>
	Site: <select name="sites">
	<option value="blcb">BLCB</option>
	<option value="blct">BLCT</option>
	<option value="bolb">BOLB</option>
	<option value="gamb">GAMB</option>
	<option value="gamt">GAMT</option>
	<option value="humb">HUMB</option>
	<option value="humt">HUMT</option>
	<option value="labb">LABB</option>
	<option value="labt">LABT</option>
	<option value="lipb">LIPB</option>
	<option value="lipt">LIPT</option>
	<option value="mamb">MAMB</option>
	<option value="mamt">MAMT</option>
	<option value="oslb">OSLB</option>
	<option value="oslt">OSLT</option>
	<option value="plab">PLAB</option>
	<option value="plat">PLAT</option>
	<option value="pugb">PUGB</option>
	<option value="pugt">PUGT</option>
	<option value="sinb">SINB</option>
	<option value="sint">SINT</option>
	<option value="sinu">SINU</option>
	</select>
	Node: <input type="number" min="1" max="40" name="node" value="1" size="0.5" onchange="showLSBChangeGeneral(this.form, 'lsb-change-canvas')"><Br/>
</p>
</form>
<div id="lsb-change-canvas" class="myLSBGraph" style="height:500px;width:750px;"></div>


</html>
