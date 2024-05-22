<!DOCTYPE HTML>
<html>
	<head>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<div id="container"></div>

<?php 
include("conn/connection.php");
$queryddga = mysql_query("SELECT n.name AS tree_name, p.name AS pname, n.in_color FROM `network_tree` AS n LEFT JOIN network_tree AS p ON p.parent_id = n.tree_id WHERE n.latitude != '' AND p.name != '' ORDER BY n.tree_id ASC");
		$tnamee = 'Due Bill Summary';
		
while($q=mysql_fetch_assoc($queryddga)){
	$Item = $q['tree_name'];
	$Total = $q['pname'];
	$myurl1[]='["'.$Item.'","'.$Total.'"]';
}

$queryddgass = mysql_query("SELECT n.name, n.in_color FROM `network_tree` AS n WHERE n.latitude != '' ORDER BY n.tree_id ASC");
		
while($qs=mysql_fetch_assoc($queryddgass)){
	$Items = $qs['name'];
	$Totals = $qs['pnames'];
//	$myurl1s[]="['".$Items."','".$Totals."']";
//	$myurl1s[]="['".$Items."','".$Totals."']";
	$myurl1s[]= '{id: "'.$Items.'", marker: {radius: 30},color:dirDist50}';
//	$myurl1s[]= "id: "Seoul ICN", marker: {radius: 30},color: dirDist50
}


?>

<script type="text/javascript">
/* eslint-disable default-case */
var dirDist50 = "#E8544E",
    dirDist10 = "#FFD265",
    dirDistLess10 = "#2AA775";

Highcharts.chart("container", {
    chart: {
        type: "networkgraph",
        marginTop: 80
    },

    title: {
        text: "South Korea domestic flight routes"
    },

    tooltip: {
        formatter: function () {
            var info = "";
            switch (this.color) {
            case dirDist50:
                console.log(dirDist50);
                info = "is an aiport <b>more than 50</b> direct distinations";
                break;
            case dirDist10:
                console.log(dirDist10);
                info = "is an aiport <b>more than 10</b> direct distinations";
                break;
            case dirDistLess10:
                console.log(dirDistLess10);
                info = "is an aiport <b>less than 10</b> direct distinations";
                break;
            }
            return "<b>" + this.key + "</b>: " + info;
        }
    },

    plotOptions: {
        networkgraph: {
            keys: ["from", "to"],
            layoutAlgorithm: {
                enableSimulation: true,
                integration: "verlet",
                linkLength: 100
            }
        }
    },

    series: [
        {
            marker: {
                radius: 13
            },
            dataLabels: {
                enabled: true,
                linkFormat: "",
                allowOverlap: true,
                style: {
                    textOutline: false
                }
            },
            data: [<?php echo(implode(",",$myurl1));?>],
            nodes: [<?php echo(implode(",",$myurl1s));?>]
        }
    ]
});

		</script>
	</head>
	<body>


	</body>
</html>
<style>
#container {
    min-width: 800px;
    max-width: 100%;
    margin: 0 auto;
    height: 1000px;
}
.highcharts-container {
width: 1904px !important;
height: 1047px !important;
}

</style>