MJax.Charts = {
	arrCharts:{},
	blnInited:false,
	Init:function(){
		if(!MJax.Charts.blnInited){
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(MJax.Charts.DrawCharts);
		}
	     
	       
	},
	InitChartPanel:function(strControlId, strChartType, objData, objOptions){
		MJax.Charts.Init();
		MJax.Charts.arrCharts[strControlId] = {};
		MJax.Charts.arrCharts[strControlId].id = strControlId;
		MJax.Charts.arrCharts[strControlId].chart_type = strChartType;
		MJax.Charts.arrCharts[strControlId].data = objData;
		MJax.Charts.arrCharts[strControlId].options = objOptions;
		
	   
	},
	DrawCharts:function(){
		for(strControlId in MJax.Charts.arrCharts){
			objChart = MJax.Charts.arrCharts[strControlId];
			var data = google.visualization.arrayToDataTable(
	         	objChart.data
	        );

	        var chart = new google.visualization[objChart.chart_type](
	        	document.getElementById(objChart.id)
	        );
	        chart.draw(data, objChart.options);
	      }
	},
	ChartTypes:{
	
	
	}



};