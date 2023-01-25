<?php
    date_default_timezone_set('America/Bogota');
    include('simple_html_dom.php');
    function getData(){
        $url = 'https://www.google.com/finance/quote/EUR-USD';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        curl_close($curl);

        $domResult = new simple_html_dom();
        $domResult -> load($result);
        foreach($domResult->find('div[class^=YMlKec fxKbKc]') as $link){
            return($link->plaintext);
        }
    }
    // echo('<h5>' . getData() . '</h5><br>');
    // echo('<h5>' . gettype(getData()) . '</h5><br>');
?>

<?php
 
$dataPoints = array();
// $y = getData();
$y = rand(-1, 1) * 0.01;
array_push($dataPoints, array("x" => 0, "y" => $y));
// for($i = 1; $i < 2; $i++){
// 	$y += rand(-1, 1) * 0.01; 
//     // $y = getData();
// 	array_push($dataPoints, array("x" => $i, "y" => $y));
// }
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <title>PreProcessor</title>
</head>
<body>
    <div class="header">
        <div class="izqHeader contHeader">
            <h1>Web Scraping Project</h1>
        </div>
        <div class="derHeader contHeader">
            <div class="dataHeader">
                <h5>Disponible</h5>
                <h3>USD $</h3>
            </div>
            <div class="dataHeader">
                <h5>Valor Actual</h5>
                <h3>USD $</h3>
            </div>
            <div class="dataHeader">
                <h5>Valor Previsto (1min)</h5>
                <h3>USD $</h3>
            </div>
            <div class="dataHeader">
                <h5>Invertido</h5>
                <h3>USD $</h3>
            </div>
        </div>
    </div>
    <div class="cont">
        <div class="content">
            <div class="izqContent contContent">
                <div id="chartContainer" style="width: 70% height: 70%">
                    <script>
                        window.onload = function() {
    
                        var dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;
                        
                        var chart = new CanvasJS.Chart("chartContainer", {
                            backgroundColor: "#ff000000",
                            zoomEnabled: true,
                            zoomType: "xy",
                            title: {
                                text: "EUR / USD",
                                fontColor: "#fefeff",
                                fontFamily: "Nunito",
                                fontWeight: "bold",
                                fontSize: 35
                            },
                            axisX:{
                                crosshair:{
                                    enabled: true,
                                    color: "#fefeff",
                                    labelBackgroundColor: "#33558b00"
                                },  
                                labelAngle: 90,
                                labelFontColor: "#fefeff",
                                labelFontFamily: "Nunito",
                                labelFontSize: 15,
                                gridColor: "#152c43"
                            },
                            axisY:{
                                crosshair:{
                                    enabled: true, 
                                    color: "#fefeff",
                                    labelBackgroundColor: "#33558b00"
                                },

                                suffix: "$",
                                interval: 0.0025,
                                labelFontColor: "#fefeff",
                                labelFontFamily: "Nunito",
                                labelFontSize: 15,
                                gridColor: "#152c43"
                            },
                            data: [{
                                type: "spline",
                                lineColor: "#16e989",
                                yValueFormatString: "#,##0.0#",
                                toolTipContent: "${y}",
                                dataPoints: dataPoints, color: "#16e98a91"
                            }]
                        });
                        chart.render();
                        
                        // var updateInterval = 1000;
                        // setInterval(function () { updateChart() }, updateInterval);
                        
                        // var xValue = dataPoints.length;
                        // var yValue = dataPoints[dataPoints.length - 1].y;

                        var yValue = dataPoints[dataPoints.length -1].y;
                        updateCount = 0;
                        
                        var updateChart = function() {
                            yValue += (Math.random() - 0.5) * 0.01;
                            // yValue = <?php echo floatVal(getData())?>;
                            updateCount++;
                            dataPoints.push({y: yValue });
                            // xValue++;
                            chart.options.title.text = "EUR / USD - Upd. " + updateCount;
                            chart.render();
                        };

                        setInterval(function(){updateChart()},5000);
                    }
                    </script>
                </div>
            </div>
            <div class="derContent contContent">
                <h1>EUR / USD</h1>  
                <table class="tb">
                    <tr>
                        <td><h3>Date</h3></td>
                        <td><h3>Value</h3></td>
                    </tr>
                    <tr class="targetable">
                        <td>
                            <?php
                                echo('<h5>'. date("M, d, Y h:i:s"). '</h5>')
                             ?>
                        </td>
                        <td class="symbol">
                            <h5 id="symbolEUR"></h5>
                        </td>
                            
                        <script>
                            document.getElementById("symbolEUR").innerHTML = <?php echo(getData())?>;    
                            setTimeout(() => {
                                document.getElementById("symbolEUR").innerHTML = <?php echo(getData())?>;    
                                document.createElement('td');
                            }, 5000);
                        </script>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>