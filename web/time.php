<!DOCTYPE HTML>
<html>
	<head>
<script src="js/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/networkgraph.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<?php 
include("conn/connection.php");
//$queryddga = mysql_query("SELECT n.tree_id, n.name AS tree_name, p.name AS pname, n.in_color FROM `network_tree` AS n LEFT JOIN network_tree AS p ON p.parent_id = n.tree_id WHERE n.latitude != '' AND p.name != '' ORDER BY n.tree_id ASC");
$queryddga = mysql_query("SELECT n.tree_id, n.parent_id, p.name AS pname, n.in_port, n.ip, n.ping, n.mk_id, d.id, n.in_color, '2' as sizee, n.out_port, n.fiber_code, n.z_id, n.box_id as weightt, d.d_name, n.name AS tree_name, n.location, n.g_location, n.note FROM network_tree AS n
LEFT JOIN device AS d ON d.id = n.device_type
LEFT JOIN network_tree AS p ON p.parent_id = n.tree_id
WHERE p.name != '' ORDER BY n.tree_id ASC");

		$tnamee = 'Due Bill Summary';
		
while($q=mysql_fetch_assoc($queryddga)){
	
	$tree_name = $q['tree_name'];
	$pname = $q['pname'];
	$ins_color = $q['in_color'];
	$tree_id = $q['tree_id'];
	
	if($tree_id == '0'){
		$size = '20';
		$color = 'red';
	}
	else{
		$size = '10';
		$color = $ins_color;
	}
	
	$myurl1[]="['".$tree_name."','".$pname."']";
	$myurl1s[]= "nodes['".$tree_id."'] = {id: '".$tree_name."', marker: {radius: ".$size."},color: '".$color."'};";
}

?>
<figure class="highcharts-figure">
    <div id="container"></div>
</figure>


<script type="text/javascript">
Highcharts.addEvent(
    Highcharts.Series,
    'afterSetOptions',
    function (e) {
        var colors = Highcharts.getOptions().colors,
            i = 0,
            nodes = {};

        if (
            this instanceof Highcharts.seriesTypes.networkgraph &&
            e.options.id === 'lang-tree'
        ) {
            e.options.data.forEach(function (link) {

					<?php echo(implode(" ",$myurl1s));?>
					
                    nodes[link[1]] = {
                        id: link[1],
                        marker: {
                            radius: 5
                        },
                        color: colors[i++]
                    };
            });

            e.options.nodes = Object.keys(nodes).map(function (id) {
                return nodes[id];
            });
        }
    }
);

Highcharts.chart('container', {
    chart: {
        type: 'networkgraph',
        height: '80%'
    },
    title: {
        text: 'TIS Network Diagram'
    },
    subtitle: {
        text: '[Testing TIS Tropology v2.6]'
    },
    plotOptions: {
        networkgraph: {
            keys: ['from', 'to'],
            layoutAlgorithm: {
                enableSimulation: true,
                friction: -0.99
            }
        }
    },
    series: [{
        accessibility: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            linkFormat: ''
        },
        id: 'lang-tree',
        data: [<?php echo(implode(",",$myurl1));?>]
    }]
});

		</script>
	</head>
	<body>


	</body>
</html>
<style>
.highcharts-figure,
.highcharts-data-table table {
    min-width: 500px;
    max-width: 100%;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 400;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>