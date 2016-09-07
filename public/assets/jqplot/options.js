/**
 *	Returns options object for jqplot.
 */
function jqplot_options() {
	return {
		animate: !$.jqplot.use_excanvas, // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
		seriesDefaults:{
			renderer:$.jqplot.BarRenderer,
			pointLabels: { show: true }
		},
		axesDefaults: {
			tickOptions: {
				showGridline: false
			}
		},
		axes: {
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer,
				ticks: []
			},
			yaxis: {
				showTicks: false,
				rendererOptions: {
					drawBaseline: false
				}
			}
		},
		highlighter: {
			show: false
		},
		grid: {
			background: 'rgba(0, 0, 0, 0)',
			borderWidth: 0
		}
	}
}