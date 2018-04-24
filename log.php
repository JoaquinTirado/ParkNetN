<?php include 'controllers/index.php' ?>
<!DOCTYPE html>
<html lang="en" >
	<?php include 'components/head.php' ?>
    <!-- end::Body -->
	<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
		<?php include 'components/header.php'; ?>
		<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<?php include 'components/menu.php' ?>
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<div class="m-content">

						<!--begin:: Widgets/Audit Log-->
						<div class="m-portlet m-portlet--full-height ">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Audit Log
											<button type="button" class="btn btn-success" id="btnExport" onclick="javascript:xport.toCSV('logs_table', 'Audit Log');">
												CSV
											</button>
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
								<center><h5>Information | Time</h5></center>
								<div class="tab-content">
									<div class="tab-pane active" id="m_widget4_tab1_content">
										<div class="m-scrollable" data-scrollable="true" data-max-height="400" style="height: 400px; overflow: hidden;">
											<div class="m-list-timeline m-list-timeline--skin-light">
												<div class="m-list-timeline__items">
													<?php
														//Zones Logs table
														$tableName = 'zones_Logs_Entry';

														//Expression attribute values
														$eav = $marshaler->marshalJson('
																{
																		":active": true,
																		":inactive": false,
																		":allowedZones": "'.$_SESSION['allowedZones'].'"
																}
														');

														$params = [
																'TableName' => $tableName,
																'ProjectionExpression' => '#id, #act, #tim, keyId',
																'FilterExpression' => '#act IN (:active, :inactive) and zoneId = :allowedZones',
																'ExpressionAttributeNames'=> [ '#id' => 'id', '#act' => 'isActive', '#tim' => 'timestamp' ],
																'ExpressionAttributeValues'=> $eav
														];

														try {
																while (true) {
																		$result = $dynamodb->scan($params);
																		foreach ($result['Items'] as $i) {
																				$log = $marshaler->unmarshalItem($i);
																						$tableName = 'zones_Keys';
																						$userId = $log['keyId'];
																						$key = $marshaler->marshalJson('{"id": "' . $userId . '"}');
																						$params = ['TableName' => $tableName, 'Key' => $key];
																						try {
																								$result = $dynamodb->getItem($params);
																								$userName = $result["Item"]["recipientName"]["S"];
																						} catch (DynamoDbException $e) {
																								// echo "Unable to get item:\n";
																								// echo $e->getMessage() . "\n";
																						}
																						if ($userName) {
																							$userName = $userName;
																						} else {
																							$userName = "Unregistered Key";
																						}
																				$access = $log['isActive'];
																				$date_date = date("Y-m-d", substr($log['timestamp'], 0, 10));
																				$date_time = date("h:i", substr($log['timestamp'], 0, 10));
																				if ($access == true) {
																					$access_text =  '<span class="m-badge m-badge--success m-badge--wide">Approved</span>';
																				} else {
																					$access_text =  '<span class="m-badge m-badge--danger m-badge--wide">Denied</span>';
																				}
																				echo '
																					<div class="m-list-timeline__item">
																						<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
																						<span href="" class="m-list-timeline__text" style="overflow: hidden;">
																							'.$userName.'<br>'.$access_text.'
																						</span>
																						<span class="m-list-timeline__time">
																							'.$date_date.'<br>'.$date_time.'
																						</span>
																					</div>
																				';
																		}

																		if (isset($result['LastEvaluatedKey'])) {
																				$params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
																		} else {
																				break;
																		}
																}

														} catch (DynamoDbException $e) {
																echo "Unable to scan:\n";
																echo $e->getMessage() . "\n";
														}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Audit Log-->
							</div>
						</div>
						<!--End::Section-->
						<table id="logs_table" class="hidden">
							<thead>
								<tr>
									<th>Name</th>
									<th>Access</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
									//Zones Logs table
									$tableName = 'zones_Logs_Entry';

									//Expression attribute values
									$eav = $marshaler->marshalJson('
											{
													":active": true,
													":inactive": false,
													":allowedZones": "'.$_SESSION['allowedZones'].'"
											}
									');

									$params = [
											'TableName' => $tableName,
											'ProjectionExpression' => '#id, #act, #tim, keyId',
											'FilterExpression' => '#act IN (:active, :inactive) and zoneId = :allowedZones',
											'ExpressionAttributeNames'=> [ '#id' => 'id', '#act' => 'isActive', '#tim' => 'timestamp' ],
											'ExpressionAttributeValues'=> $eav
									];

									try {
											while (true) {
													$result = $dynamodb->scan($params);
													foreach ($result['Items'] as $i) {
															$log = $marshaler->unmarshalItem($i);
																	$tableName = 'zones_Keys';
																	$userId = $log['keyId'];
																	$key = $marshaler->marshalJson('{"id": "' . $userId . '"}');
																	$params = ['TableName' => $tableName, 'Key' => $key];
																	try {
																			$result = $dynamodb->getItem($params);
																			$userName = $result["Item"]["recipientName"]["S"];
																	} catch (DynamoDbException $e) {
																			// echo "Unable to get item:\n";
																			// echo $e->getMessage() . "\n";
																	}
																	if ($userName) {
																		$userName = $userName;
																	} else {
																		$userName = "Unregistered Key";
																	}
															$access = $log['isActive'];
															$date = date("Y-m-d h:i", substr($log['timestamp'], 0, 10));
															if ($access == true) {
																$access_text_table = 'Approved';
															} else {
																$access_text_table = 'Denied';
															}
															echo '
																		<tr>
																			<td>'.$userName.'</td>
																			<td>'.$access_text_table.'</td>
																			<td>'.$date.'</td>
																		</tr>
															';
													}

													if (isset($result['LastEvaluatedKey'])) {
															$params['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
													} else {
															break;
													}
											}

									} catch (DynamoDbException $e) {
											echo "Unable to scan:\n";
											echo $e->getMessage() . "\n";
									}
								?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
			<!-- end:: Body -->
			<?php include 'components/footer.php' ?>
		</div>
		<!-- end:: Page -->

	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<input type="hidden" id="pageid" value="log">
		<!-- end::Scroll Top -->
    	<?php include 'components/foot-scripts.php' ?>
	</body>
	<!-- end::Body -->
</html>
