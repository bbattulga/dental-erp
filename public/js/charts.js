console.log('charts');

function treatmentBarChart(canvasElem, arr_male_ages, arr_female_ages){
    
}

var rootStyle = getComputedStyle(document.body);
    var themeColor1 = rootStyle.getPropertyValue("--theme-color-1").trim();
    var themeColor2 = rootStyle.getPropertyValue("--theme-color-2").trim();
     var themeColor1_10 = rootStyle
      .getPropertyValue("--theme-color-1-10")
      .trim();
    var themeColor2_10 = rootStyle
      .getPropertyValue("--theme-color-2-10")
      .trim();
    var themeColor3_10 = rootStyle
      .getPropertyValue("--theme-color-3-10")
      .trim();
    var themeColor4_10 = rootStyle
      .getPropertyValue("--theme-color-4-10")
      .trim();

    var themeColor5_10 = rootStyle
      .getPropertyValue("--theme-color-5-10")
      .trim();
    var themeColor6_10 = rootStyle
      .getPropertyValue("--theme-color-6-10")
      .trim();

        var primaryColor = rootStyle.getPropertyValue("--primary-color").trim();
    var foregroundColor = rootStyle
      .getPropertyValue("--foreground-color")
      .trim();
    var separatorColor = rootStyle.getPropertyValue("--separator-color").trim();

        var chartTooltip = {
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

       if (document.getElementById("treatmentChart")) {

        let age_male = JSON.parse(document.getElementById('treatment1_age_male').value);
        let age_female = JSON.parse(document.getElementById('treatment1_age_female').value);
        console.log(age_male);
        var treatmentChart = document
          .getElementById("treatmentChart")
          .getContext("2d");
        
        var treatmentChart = new Chart(treatmentChart, {
          type: "bar",
          options: {
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
                    labelString: 'Үйлчлүүлэгчдийн тоо'
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
                    max: 20,
                    step: 1,
                    padding: 20,
                  }
                }
              ],
              xAxes: [
                {
                    scaleLabel: {
                    display: true,
                    labelString: 'Нас'
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
          },
          data: {
            labels: ["0-4", "4-8", '8-12', "12-16", "16-20", "20-24", "24-28",
                        "28-32", '32-36', '36-40', '40-44', '44-48', '48-52', '52-56', '56-60', '60-с дээш',
                            ],

            datasets: [
              {
                label: "эрэгтэй",
                borderColor: themeColor1,
                backgroundColor: themeColor1_10,
                data: age_male,
                borderWidth: 2,
              },
              {
                label: "эмэгтэй",
                borderColor: themeColor2,
                backgroundColor: themeColor2_10,
                data: age_female,
                borderWidth: 2,
              },
            ]
          }
        });
      } // end treatmentChart