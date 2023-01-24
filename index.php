<?php
    function getData(){
        include('simple_html_dom.php');
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
            echo('<h5>$ ' . $link->plaintext . '</h5><br>');
        }
    }
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
                <div class="tradingview-widget-container">
                <div id="tradingview_091a9"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                new TradingView.widget(
                {
                "width": "98%",
                "height": "98%",
                "symbol": "FX:EURUSD",
                "interval": "1",
                "timezone": "America/Bogota",
                "theme": "dark",
                "style": "2",
                "locale": "es",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "hide_top_toolbar": true,
                "hide_legend": true,
                "save_image": false,
                "container_id": "tradingview_091a9"
                }
                );
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
                        <td><h5>EUR / USD</h5></td>
                        <td class="symbol">
                            <?php
                                getData();
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>