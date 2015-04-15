<?php $this->assign('title', 'Tableaux de statistique'); 

$this->Html->css('jqplot', 
        array('inline' => false));

echo $this->Html->script(array(
            'jqplot/jquery.jqplot.min', 
            'jqplot/plugins/jqplot.json2.min',
            'jqplot/plugins/jqplot.dateAxisRenderer.min',
            'jqplot/plugins/jqplot.canvasTextRenderer.min',
            'jqplot/plugins/jqplot.canvasAxisTickRenderer.min',
            'jqplot/plugins/jqplot.categoryAxisRenderer.min',
            'jqplot/plugins/jqplot.barRenderer.min',
            
            'jqplot/plugins/jqplot.pieRenderer.min.js',
            'jqplot/plugins/jqplot.donutRenderer.min.js',
            
            'jqplot/plugins/jqplot.highlighter.min.js',
            'jqplot/plugins/jqplot.cursor.min.js',
            'jqplot/plugins/jqplot.funnelRenderer.min.js',
            'jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js',
                         
            'script.js'
        ));

?>



<div class="example-plot" id="chart1"></div>
<div class="example-plot" id="chart2"></div>
<div class="example-plot" id="chart3"></div>
<div class="example-plot" id="chart4"></div>
 

