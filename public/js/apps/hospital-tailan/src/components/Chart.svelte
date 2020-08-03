<script context="module">
	// basic configurations
	export let rootStyle = getComputedStyle(document.body);
    export let themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    export let themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
    export let themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    export let themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    export let themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    export let themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    export let themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    export let themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

    export let primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    export let foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    export let separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

    export let chartTooltip = {
	    backgroundColor: foregroundColor,
	    titleFontColor: primaryColor,
	    borderColor: separatorColor,
	    borderWidth: 0.5,
	    bodyFontColor: primaryColor,
	    bodySpacing: 10,
	    xPadding: 15,
	    yPadding: 15,
	    cornerRadius: 0.15,
	    displayColors: false
  	};
</script>

<script>

	import ChartContainer from './ChartContainer.svelte';
	import {onMount, onDestroy} from 'svelte';
	import Chart from 'chart.js';

  export let horizontalLabel = 'Эмчилгээний тоо';
  export let verticalLabel = 'Нас';

	export let type = 'bar';
  	export let labels = [	
			"0-4", "4-8", '8-12', "12-16", "16-20", "20-24", "24-28",
        	"28-32", '32-36', '36-40', '40-44', '44-48', '48-52', '52-56', '56-60', '60-с дээш',
        ];

  	export let datasets = [
              {
                label: "эрэгтэй",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: [],
                borderWidth: 2,
              },
              {
                label: "эмэгтэй",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: [],
                borderWidth: 2,
              },
		   ]

    export let data = {
            labels,
            datasets,
          }
  export let ymax = Math.max(Math.max(...datasets[datasets.length-1].data), Math.max(...datasets[0].data));
	export let options = {
            plugins: {
              datalabels: {
                display: false
              }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              yAxes: [
                {
                    scaleLabel: {
                    display: true,
                    labelString: verticalLabel
                  },
                    stacked: false,
                  gridLines: {
                    display: true,
                    lineWidth: 1,
                    color: "rgba(0,0,0,0.1)",
                    drawBorder: false
                  },
                  ticks: {
                    beginAtZero: true,
                    min: 1,
                    max: ymax,
                    step: 1,
                    padding: 20,
                  }
                }
              ],
              xAxes: [
                {
                    scaleLabel: {
                    display: true,
                    labelString: horizontalLabel
                  },

                    beginAtZero: true,
                    stacked: false,
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    display: true,  
                    autoSkip: false,
                  }
                }
              ]
            },
            legend: {
              position: "bottom",
              labels: {
                padding: 30,
                usePointStyle: true,
                fontSize: 12,
              }
            },
            tooltips: chartTooltip
          }; // options end


    // create chart
    let canvas;
    onMount(()=>{
    	let chart = new Chart(canvas, {type, options, data});
    });

    onDestroy(()=>{

    });
</script>

<canvas bind:this={canvas}></canvas>

