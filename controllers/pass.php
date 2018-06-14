<?php session_start();
include '../initialize.php';
use PKPass\PKPass;

require('../assets/vendors/PKPass/PKPass.php');

if(isset($_GET['keyId'])) {
    //Users table
		$tableName = 'zones_Keys';
		// //Capture variables

    //Always Active Key Example
    // $keyId = "ec5972bb-30be-470e-8854-95084e0e0f61";
    //Working Hours Key Example
    // $keyId = "ba8d3cdc-e14f-4453-9217-c04b2d369cce";
    //By Period Key Example
    // $keyId = "7a724f0b-48c6-46ed-86b8-89f07c10e1cc";

    $keyId = $_GET['keyId'];

		$key = $marshaler->marshalJson('
		    {
		        "id": "' . $keyId . '"
		    }
		');

		$params = [
		    'TableName' => $tableName,
		    'Key' => $key
		];

		try {

        $result = $dynamodb->getItem($params);

		    if ($result["Item"]) {
          $key = $marshaler->unmarshalItem($result["Item"]);
          //Zone Name
          if ($key["zoneId"] == "parallel18_1"){
            $zone_name = "Parallel 18";
            $locations = '{"latitude" : 18.450112, "longitude" : -66.073820}';
          } else if ($key["zoneId"] == "cocohaus_1"){
            $zone_name = "Co.Co.Haus";
            $locations = '{"latitude" : 18.444669, "longitude" : -66.065777}';
          } else if ($key["zoneId"] == "test_1"){
            $zone_name = "Inteldot";
            $locations = '{"latitude" : 18.448005, "longitude" : -66.070752}';
          }  else if ($key["zoneId"] == "vitech_1"){
            $zone_name = "Vitech";
            $locations = '{"latitude" : 18.207144, "longitude" : -67.128187}';
          } else if ($key["zoneId"] == "inteldot_1"){
            $zone_name = "Inteldot";
            $locations = '{"latitude" : 18.448005, "longitude" : -66.070752}';
          } else {
						$zone_name = "Inteldot";
            $locations = '{"latitude" : 18.448005, "longitude" : -66.070752}';
          }

          //Key Type
          $secondaryFields = "";
          if ($key["keyType"] == "always") {
            $key_type = "Always Active";
          } else if ($key["keyType"] == "workingHours") {
            $key_type = "Working Hours (9AM - 6PM)";
          } else if ($key["keyType"] == "period") {
            $key_type = "By Period";
            $start_date = date('m/d/Y H:i', $key["keyStartTimestamp"]);
            $end_date = date('m/d/Y H:i', $key["keyEndTimestamp"]);
            $secondaryFields = '{
                "key": "start",
                "label": "Start Period",
                "value": "' . $start_date . '"
            },
            {
                "key": "end",
                "label": "End Period",
                "value": "' . $end_date . '"
            }';
          } else {
            $key_type = "Unknown Key Type";
          }

          //Recipient
          if ($key["recipientName"]) {
            $recipient = $key["recipientName"];
          } else {
            $recipient = "Unknown";
          }

        } else {
          print_r('No Key Found');
        }

		} catch (DynamoDbException $e) {
		    echo "Unable to get item:\n";
		    echo $e->getMessage() . "\n";
		}

    // Create pass

    //Set certificate and path in the constructor
    $pass = new PKPass('../assets/vendors/PKPass/Certificate/Certificates.p12', 'P@rknetP@ss!');

    //Check if an error occurred within the constructor
    if($pass->checkError($error) == true) {
        exit('An error occurred: ' . $error);
    }

    // Set pass data
    $pass->setData('{
	"passTypeIdentifier": "pass.com.parknet",
	"formatVersion": 1,
	"organizationName": "Parknet",
	"serialNumber": "' . $keyId . '",
	"teamIdentifier": "9L5685F945",
	"sharingProhibited": true,
	"backgroundColor": "rgb(14,158,124)",
	"logoText": "Parknet Pass",
	"description": "Parknet Pass",
	"storeCard": {
        "primaryFields": [
            {
            	"key" : "zone",
            	"label" : "' . $key_type . '",
            	"value" : "' . $zone_name . '",
              "textAlignment" : "PKTextAlignmentCenter"
            }
        ],
        "secondaryFields": ['.$secondaryFields.'],
        "backFields": [
            {
                "key": "recipient-name",
                "label": "Recipient",
                "value": "' . $recipient . '"
            }
        ],
        "transitType" : "PKTransitTypeAir"
    },
    "barcode": {
        "format": "PKBarcodeFormatQR",
        "message": "' . $keyId . '",
        "messageEncoding": "iso-8859-1"
    },
    "locations" : [ '.$locations.' ],
    }');
    if($pass->checkError($error) == true) {
        exit('An error occured: ' . $error);
    }

    // Add files to the PKPass package
    $pass->addFile('../assets/demo/default/media/img/misc/icon.png');
    $pass->addFile('../assets/demo/default/media/img/misc/icon@2x.png');
    $pass->addFile('../assets/demo/default/media/img/misc/logo.png');

    if($pass->checkError($error) == true) {
        exit('An error occured: ' . $error);
    }
    // Create and output the PKPass
    // If you pass true, the class will output the zip into the browser.
    $result = $pass->create(true);
    if($result == false) {
        echo $pass->getError();
    }
} else {
    // User lands here, there are no $_POST variables set
	?>
	<!-- <html>
	<head>
		<title>Flight pass creator - PHP class demo</title>
		<meta name="viewport" content="width=320; user-scalable=no"/>
		<style>
            body {
                font-family: Helvetica, sans-serif;
            }
			.header {
				color: white;
				background-color: #6699cc;
				padding-top: 30px;
				padding-bottom: 30px;
				margin-bottom: 32px;
				text-align: center;
			}

			.logo {
				width: 64px;
				height: 64px;
				margin-bottom: 20px;
			}

			.title {
				color: white;
				font-size: 22px;
				text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
				font-weight: bold;
				display: block;
				text-align: center;
			}

			.userinfo {
				margin: 0 auto;
				padding-bottom: 32px;
				width: 280px;
			}

			form.form-stacked {
				padding: 0;
			}

			legend {
				text-align: center;
				padding-bottom: 25px;
				clear: both;
				border-bottom: none;
			}

			input.xlarge {
				width: 280px;
				height: 26px;
				line-height: 26px;
			}
		</style>
	</head>
	<body>
	<div class="header">
		<img class="logo" src="icon.png"/> <span class="title">Air Company</span>
	</div>
	<div class="userinfo">
		<form action="pass-example.php" method="post" class="form-stacked">
			<fieldset>
				<legend style="padding-left: 0;">Please enter your info</legend>

				<div class="clearfix">
					<label style="text-align:left">Flight schedule</label>
					<div class="input">
						<select name="origin" style="width: auto;">
							<option value="SFO">San Francisco</option>
							<option value="LAX">Los Angeles</option>
							<option value="LHR">London</option>
						</select> &nbsp; to &nbsp; <select name="destination" style="width: auto;">
							<option value="SFO">San Francisco</option>
							<option value="LAX">Los Angeles</option>
							<option value="LHR">London</option>
						</select>
					</div>
				</div>

				<div class="clearfix">
					<label style="text-align:left">Passenger name</label>
					<div class="input">
						<input class="xlarge" name="passenger" type="text" value="" placeholder="John Appleseed"/>
					</div>
				</div>

				<div class="clearfix">
					<label style="text-align:left">Flight date</label>
					<div class="input">
						<select name="date" style="width: 100%;">
							<option value="<?= time(); ?>">Today</option>
							<option value="<?= (time() + 86400); ?>">Tomorrow</option>
							<option value="<?= (time() + (86400 * 7)); ?>">Next week</option>
						</select>
					</div>
				</div>

				<br/><br/>
				<center><input type="submit" class="btn primary" value=" Create pass &gt; "/></center>
			</fieldset>
		</form>

	</div>
	</body>
	</html> -->
<?php } ?>
