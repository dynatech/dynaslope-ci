
<!--     Created by: Kevin Dhale dela Cruz
    A view page for monitoring sites with alerts; 
    acts as a homepage
    Linked at [host]/home or [host]/dashboard  -->


<link rel="stylesheet" type="text/css" href="css/dewslandslide/public_alert/monitoring_dashboard.css">
<script src="<?php echo base_url();?>js/dewslandslide/public_alert/dashboard_server.js"></script>
<script type="text/javascript" src="js/dewslandslide/public_alert/monitoring_dashboard.js"></script>
<script type="text/javascript" src="js/dewslandslide/public_alert/bulletin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/issues_and_reminders.js"></script>
<script src="<?php echo base_url(); ?>js/third-party/notify.min.js"></script>
<script src="<?php echo base_url(); ?>js/third-party/typeahead.js"></script>
<script src="<?php echo base_url(); ?>js/third-party/bootstrap-tagsinput.js"></script>
<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">

<script type="text/javascript" src="js/dewslandslide/communications_beta/cbx_dashboard.js"></script>
<script type="text/javascript" src="js/dewslandslide/communications_beta/websocket_server.js"></script>
<script type="text/javascript" src="js/dewslandslide/communications_beta/event_handler.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications_beta/ground_meas.js"></script>

<?php  
	$sites = json_decode($sites);
	$staff = json_decode($staff);
	$events = json_decode($events);
?>

<div id="page-wrapper">
	<div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div id="page-header">SITE ALERT MONITORING <small>DASHBOARD</small></div>
            </div>
        </div>

        <div class="alert alert-danger" id="primer">
            <strong>Monitoring Modules Directory</strong>: 
            <ul>
            	<li>Read and file announcements on <a role="button" id="iar_modal_link"><strong>Monitoring Issues And Reminders Modal</strong></a>.</li>
            	<li>Allot some time to read the <strong><a href="<?php echo base_url(); ?>monitoring/faq">Monitoring Primer and Frequently Asked Questions (FAQ)</a></strong> page.</li>
            </ul>
        </div>

        <div class="row">
		    <div class="col-sm-12" id="column_2">
		    	<div id="automation-row" hidden="hidden">
		    		<div class="row">
			    		<div class="col-sm-12 text-center" style="background-color:red;color:white;">
			    			NOTE: These automation features are experimental!
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-sm-6" style="background-color:red;color:white;">
			    			<label class="checkbox-inline"><input id="alert_release" type="checkbox">Automate Alert Release <span id="alert_release_staff"></span></label>
			    		</div>
			    		<div class="col-sm-6" style="background-color:red;color:white;">
			    			<label class="checkbox-inline"><input id="bulletin_sending" type="checkbox">Automate Bulletin Release <span id="bulletin_sending_staff"></span></label>
			    		</div>
			    	</div>
		    	</div>

			</div>
		</div>

        <div class="row">
		    <div class="col-sm-12">
		    	<div id="gndmeas-row" hidden="hidden">
	    			<button type="button" id="dashboard-gndmeas-settings" class="btn btn-info btn-lg btn-block">Semi-Automated Ground Measurement Reminder</button>
		    	</div>
			</div>
		</div>

		<ul class="nav nav-tabs nav-justified">
    		<li class="active"><a data-toggle="tab" href="#monitoring-tab"><strong>DASHBOARD TABLES</strong></a></li>
    		<li><a data-toggle="tab" href="#generated-alerts-tab"><strong>GENERATED ALERTS</strong></a></li>
    	</ul>

		<div class="tab-content">
			<div id="monitoring-tab" class="tab-pane fade in active">
				<br/>
				<?php echo $monitoring ?>
			</div>
			<div id="generated-alerts-tab" class="tab-pane fade in">
				<?php echo $generated_alerts ?>
			</div>
		</div>

		<!------------- MODALS AREA ------------>

		<!-- SMS EWI MODAL -->
        <div class="modal fade col-lg-10" id="ewi-asap-modal" role="dialog">
            <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                <div class="modal-content" id="ewi-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>EARLY WARNING INFORMATION</h4>
                    </div>
                    <input type="hidden" id="event_details">
                    <div class="modal-body row-fluid">
                    	<h4>Default Recipients:</h4>
						<div id="ewi-recipients-container">
	                    	<input class="form-control" type="text" id="ewi-recipients-dashboard" data-role="tagsinput" data-provide="typeahead" style="display:none" required>
	                    	<input type="text" id="default-recipients" style="display:none">
	                    	<input type="text" id="all-recipients" style="display:none">
						</div>

                    	<h4>Optional Recipients:</h4>
						<textarea class="form-control" name="additional_recipients" id="additional-recipients" cols="30" style="resize:none" disabled></textarea>
                        <textarea style="resize:none" name="constructed-ewi" id="constructed-ewi-amd" cols="30" rows="10" class="form-control" disabled></textarea>
                        <div class="ewi-cmd-container">
	                        <button type="button" id="edit-btn-ewi-amd" class="btn btn-warning" value="edit">Edit</button>
	                        <button type="button" id="send-btn-ewi-amd" class="btn btn-success">Send</button>
                        </div>
                        <input type="hidden" name="site_abbr" id="site-abbr">
                        <input type="hidden" id="extended_status">
                        <input type="hidden" name="footer_ewi" id="footer-ewi" value="<?php echo $first_name; ?>">
                    </div>
                </div>  
            </div>
        </div> <!-- END OF SMS EWI MODAL -->

        <!-- SUCCESS SMS EWI MODAL -->
        <div class="modal fade col-lg-10" id="success-ewi-modal" role="dialog">
            <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                <div class="modal-content" id="ewi-content">
                    <div class="modal-body row-fluid"> 
                   	<button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2><span id="result-ewi-message"></span></h2>
                    </div>
                </div>  
            </div>
        </div> <!-- END OF SMS EWI MODAL -->

		<!-- JSON ERROR MODAL AREA -->
		<div class="modal fade" id="errorProcessingModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
	   					<h4><strong>Monitoring Dashboard Error</strong></h4>
					</div>
    				<div class="modal-body">
    					<div style="color:red;">
    						There is an error loading the file PublicAlert.JSON. Please refresh the page and see if that solves the problem. If the loading problem persists, use the Alert Release Form for releasing EWI instead.
    					</div>
     				</div>
     				<div class="modal-footer">
		        		<button class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of JSON ERROR MODAL AREA -->

		<!-- RESULT MODAL AREA -->
	    <div class="modal fade" id="resultModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
					</div>
    				<div class="modal-body">
     				</div>
     				<div class="modal-footer">
		        		<button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of RESULT MODAL AREA -->

		<!-- RELEASE MODAL AREA -->
		<div class="modal fade" id="release-modal" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Early Warning Alert Release</h4>
                    </div>

                    <form id="modalForm" name='form' role='form'>
                    <div class="modal-body">
                    	
                    	<div id="invalid_template" hidden="hidden">
	                        <div class="row">
	                        	<div class="col-sm-12 text-center">
	                        		<span class="glyphicon glyphicon-warning-sign"></span>&ensp;This trigger was tagged <strong>INVALID</strong> by <strong><span id="staff">Community</span></strong>.&ensp;<span class="glyphicon glyphicon-warning-sign"></span>
	                        	</div>
	                        </div>
	                        <div class="row">
	                        	<div class="col-sm-12 text-center"><strong>Date/Time:&ensp;</strong> <span id="timestamp">Dec. 26, 2017, 19:30:00</span></div>
	                        </div>
	                        <div class="row">
	                        	<div class="col-sm-12 text-center"><strong>Remarks:&ensp;</strong><span id="remarks">Disp alert was caused by a data jump.</span>
	                        	</div>
	                        </div>
	                        <hr/>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="timestamp_entry">Data Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="timestamp_entry" name="timestamp_entry" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>        
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="release_time">Time of Release</label>
                                <div class='input-group date time' >
                                    <input type='text' class="form-control" id="release_time" name="release_time" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>  
                            </div>
                        </div>

                        <div id="routine-release">
                        	<div class="row line"><hr></div>
                        	<div class="form-group">
                        		<label>ROUTINE SITES</label>
                        		<div><small>Note: Invalid entries (if there's any) are INCLUDED in this routine. It is the monitoring personnels' duty to check if surficial data received are read and stored in our database. Any missed data rendering a site's internal alert from A0 to ND is NOT the module's fault. Use the Mass Routine EWI Release in the Alert Release Form if there are discrepancies found in this module.</small></div>
                        	</div>
	                        <div class="row">
	                            <div class="col-sm-6">
	                                <label for="alert-0">Alert 0</label>
	                                <textarea class="form-control" rows="3" id="alert-0" name="alert-0" maxlength="360" disabled="disabled" placeholder="No site available"></textarea>
	                                <small><strong>Number of sites:</strong> <span id="alert-0-count"></span></small>
	                            </div>
	                            <div class="col-sm-6">
	                                <label for="nd-alert-0">No Data (Alert 0)</label>
	                                <textarea class="form-control" rows="3" id="nd-alert-0" name="nd-alert-0" maxlength="360" disabled="disabled" placeholder="No site available"></textarea>
	                                <small><strong>Number of sites:</strong> <span id="nd-alert-0-count"></span></small>
	                            </div>
	                        </div>
                        </div>

                        <div id="regular-release" hidden>
	                        <div class="row">
	                        	<div class="col-sm-6 form-group">
		                            <label for="site_id">Site Name</label>
		                            <select class="form-control" id="site_id" name="site_id" readonly="readonly">
		                                <option value="">---</option>
		                                <?php foreach($sites as $site): ?>
		                                    <?php if($site->site_code != 'mes'): ?>
		                                        <option value="<?php echo $site->site_id; ?>">
		                                        <?php echo strtoupper($site->site_code) . " (" . $site->address . ")"; ?>
		                                        </option>
		                                    <?php endif; ?>
		                                <?php endforeach; ?>
		                            </select>
	                        	</div>
	                        	<div class="col-sm-6 form-group">
	                            	<label for="internal_alert_level">Internal Alert</label>
	                            	<input type="text" class="form-control" id="internal_alert_level" name="internal_alert_level" readonly="true">
	                        	</div>
	                        </div>

	                        <div id="od_area" hidden="hidden">
	                            <div class="row line"><hr></div>
	                            <div class="row">
	                            	<div class="col-sm-3 text-center area_label"><h4><b>ON-DEMAND</b></h4></div>
		                            <div class="col-sm-9">
		                                <div class="row">
		                                    <div class="col-sm-12 form-group">
		                                        <label class="control-label" for="trigger_od">Request Timestamp</label>
		                                        <div class='input-group date datetime'>
		                                            <input type='text' class="form-control trigger_time" id="trigger_od" name="trigger_od" placeholder="Enter timestamp" disabled="disabled" />
		                                            <span class="input-group-addon">
		                                                <span class="glyphicon glyphicon-calendar"></span>
		                                            </span>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="row">
		                                    <div class="col-sm-12 form-group">
		                                        <label for="trigger_od_info">Requested by</label>
		                                        <div class="input-group">
		                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="od_group" value="llmc" disabled="disabled">LEWC</label>
		                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="od_group" value="lgu" disabled="disabled">LGU</label>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="row">
		                                    <div class="col-sm-12 form-group">
		                                        <label for="reason">Reason for Request</label>
		                                        <div class="input-group">
		                                            <span class="input-group-addon" id="basic-addon3">Monitoring requested due to</span>
		                                            <textarea class="form-control" rows="1" id="reason" name="reason" placeholder="Enter reason for request." maxlength="200" aria-describedby="basic-addon3" disabled="disabled"></textarea>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="row">
		                                    <div class="col-sm-12 form-group">
		                                        <label for="trigger_od_info">Current Site Info:</label>
		                                        <textarea class="form-control trigger_info" rows="1" id="trigger_od_info" name="trigger_od_info" placeholder="Enter basic site details" maxlength="200" disabled="disabled"></textarea>
		                                    </div>
		                                </div>
		                            </div>
	                            </div>
	                        </div>

	                        <div id="rainfall_area" hidden="hidden">
	                        	<div class="row line"><hr></div>
	                        	<div class="invalid_area"></div>
	                        	<div class="row">
	                        		<div class="col-sm-3 text-center area_label">
	                        			<div class="row"><h4><b>RAINFALL</b></h4></div>
	                        			<div class="row">
	                        				<div class="form-group col-sm-12">
		                        				<div class="checkbox">
		  											<label><input class="trigger_switch" name="trigger_switch" type="checkbox" value="rainfall">Include</label>
												</div>
	                        				</div>
	                        				
										</div>
	                        		</div>
	                                <div class="col-sm-9">
	                                    <div class="row">
	                                        <div class="form-group col-sm-12">
	                                            <label for="trigger_rainfall">Trigger Timestamp</label>
	                                            <div class='input-group date datetime'>
	                                                <input type='text' class="form-control" id="trigger_rainfall" name="trigger_rainfall" disabled="disabled"/>
	                                                <span class="input-group-addon">
	                                                    <span class="glyphicon glyphicon-calendar"></span>
	                                                </span>
	                                            </div>
	                                        </div>
	                                        <div class="col-sm-12 form-group">
	                                            <label for="trigger_rainfall_info">Technical Info:</label>
	                                            <textarea class="form-control trigger_info" rows="1" id="trigger_rainfall_info" name="trigger_rainfall_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                        </div>
	                                    </div>
	                                </div> 
	                        	</div>                                  
	                        </div>

	                        <div id="eq_area" hidden="hidden">
	                        	<div class="row line"><hr></div>
	                        	<div class="row">
	                        		<div class="col-sm-4 text-center area_label"><h4><b>EARTHQUAKE</b></h4></div>
		                            <div class="form-group col-sm-8">
		                                <label for="trigger_eq">Trigger Timestamp</label>
		                                <div class='input-group date datetime'>
		                                    <input type='text' class="form-control" id="trigger_eq" name="trigger_eq" disabled="disabled"/>
		                                    <span class="input-group-addon">
		                                        <span class="glyphicon glyphicon-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
	                        	</div>
	                        	<div class="row">
		                        	<div class="col-sm-4 form-group">
		                                <label for="magnitude">Magnitude</label>
		                                <input type="number" step="0.1" min="0" class="form-control" id="magnitude" name="magnitude" disabled="disabled">
		                            </div>
		                            <div class="col-sm-4 form-group">
		                                <label for="latitude">Latitude</label>
		                                <input type="number" step="0.1" min="0" class="form-control" id="latitude" name="latitude" disabled="disabled">
		                            </div>
		                            <div class="col-sm-4 form-group">
		                                <label for="longitude">Longitude</label>
		                                <input type="number" step="0.1" min="0" class="form-control" id="longitude" name="longitude" disabled="disabled">
		                            </div>
	                        	</div>
	                            <div class="row">
	                                <div class="col-sm-12 form-group">
	                                    <label for="trigger_eq_info">Technical Info:</label>
	                                    <textarea class="form-control trigger_info" rows="1" id="trigger_eq_info" name="trigger_eq_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                </div>      
	                            </div>             
	                        </div>

	                        <div id="surficial_area" hidden="hidden">
	                        	<div class="row line"><hr></div>
	                        	<div class="row">
	                        		<div class="col-sm-3 text-center area_label"><h4><b>SURFICIAL</b></h4></div>
	                                <div class="col-sm-9">
	                                    <div class="row">
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_surficial_1">L2 (g) Trigger Timestamp</label>
	                                            <div class='input-group date datetime'>
	                                                <input type='text' class="form-control" id="trigger_surficial_1" name="trigger_surficial_1" disabled="disabled"/>
	                                                <span class="input-group-addon">
	                                                    <span class="glyphicon glyphicon-calendar"></span>
	                                                </span>
	                                            </div>
	                                        </div>
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_surficial_2">L3 (G) Trigger Timestamp</label>
	                                            <div class='input-group date datetime'>
	                                                <input type='text' class="form-control" id="trigger_surficial_2" name="trigger_surficial_2" disabled="disabled"/>
	                                                <span class="input-group-addon">
	                                                    <span class="glyphicon glyphicon-calendar"></span>
	                                                </span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_surficial_1_info">Technical Info:</label>
	                                            <textarea class="form-control trigger_info" rows="1" id="trigger_surficial_1_info" name="trigger_surficial_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                        </div>
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_surficial_2_info">Technical Info:</label>
	                                            <textarea class="form-control trigger_info" rows="1" id="trigger_surficial_2_info" name="trigger_surficial_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                        </div>
	                                    </div>
	                                </div>
	                        	</div>                            
	                        </div>

	                        <div id="subsurface_area" hidden="hidden">
	                        	<div class="row line"><hr></div>
	                        	<div class="invalid_area"></div>

	                        	<div class="row">
	                        		<div class="col-sm-3 text-center area_label">
	                        			<div class="row"><h4><b>SUBSURFACE</b></h4></div>
	                        			<div class="row">
	                        				<div class="form-group col-sm-12">
		                        				<div class="checkbox">
		  											<label><input class="trigger_switch" name="trigger_switch[]" type="checkbox" value="subsurface">Include</label>
												</div>
	                        				</div>
										</div>
	                        		</div>
	                        		<div class="col-sm-9">
	                                    <div class="row">
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_subsurface_1">L2 (s) Trigger Timestamp</label>
	                                            <div class='input-group date datetime'>
	                                                <input type='text' class="form-control" id="trigger_subsurface_1" name="trigger_subsurface_1" disabled="disabled"/>
	                                                <span class="input-group-addon">
	                                                    <span class="glyphicon glyphicon-calendar"></span>
	                                                </span>
	                                            </div>
	                                        </div>
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_subsurface_2">L3 (S) Trigger Timestamp</label>
	                                            <div class='input-group date datetime'>
	                                                <input type='text' class="form-control" id="trigger_subsurface_2" name="trigger_subsurface_2" disabled="disabled"/>
	                                                <span class="input-group-addon">
	                                                    <span class="glyphicon glyphicon-calendar"></span>
	                                                </span>
	                                            </div>
	                                        </div>
	                                    </div>
	                                    <div class="row">
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_subsurface_1_info">Technical Info:</label>
	                                            <textarea class="form-control trigger_info" rows="1" id="trigger_subsurface_1_info" name="trigger_subsurface_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                        </div>
	                                        <div class="form-group col-sm-6">
	                                            <label for="trigger_subsurface_2_info">Technical Info:</label>
	                                            <textarea class="form-control trigger_info" rows="1" id="trigger_subsurface_2_info" name="trigger_subsurface_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                    	</div>
                        </div>
                        

                        <div class="row line"><hr></div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" rows="3" id="comments" name="comments" maxlength="360" ></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="reporter_1">Reporter 1</label>
                                <input type="text" class="form-control" id="reporter_1" name="reporter_1" value-id="<?php echo $user_id; ?>" value="<?php echo $last_name . ", " . $first_name; ?>" placeholder="---" readonly="readonly">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="reporter_2">Reporter 2</label>
                                <select class="form-control" id="reporter_2" name="reporter_2">
                                    <option value="">---</option>
                                    <?php foreach($staff as $person): ?>
                                        <?php if( $person->id != $user_id): ?>
                                            <option value="<?php echo $person->id; ?>">
                                            <?php echo $person->last_name . ", " . $person->first_name; ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="release" class="btn btn-danger" role="button" type="submit">Release Alert</button>
                        <button class="btn btn-default" data-dismiss="modal" role="button">Cancel</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- End of RELEASE MODAL AREA -->

        <!-- MANUAL INPUT MODAL AREA -->
		<div class="modal fade" id="manualInputModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
	   					<h4><strong>Early Warning Information Release</strong></h4>
					</div>
    				<div class="modal-body">
    					<div style="color:red;">The data from the trigger source of this site alert has been invalidated, and thus manual source checking must be performed. Release the Early Warning Information using the Alert Release Form.</div>
     				</div>
     				<div class="modal-footer">
		        		<button class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of MANUAL INPUT MODAL AREA -->

		<!-- MODAL AREA -->
		<div class="modal fade" id="error-modal" role="dialog">
		    <div class="modal-dialog">
		        <!-- Modal content-->
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal">&times;</button>
		                <h4 class="modal-title">Monitoring Dashboard Error</h4>
		            </div>
		            <div class="modal-body">
		                <p>Problem loading some parts of this page:</p>
		                <ul></ul>
		                See console for error details.
		            </div>
		            <div class="modal-footer">
		                <button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		            </div>
		        </div>
		    </div>
		</div> <!-- End of MODAL AREA -->

		<!-- IMPORT BULLETIN MODALS -->
		<?php echo $bulletin_modals; ?>
	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->