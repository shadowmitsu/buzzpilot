var colors=["#39afd1"],dataColors=$("#basic-radialbar").data("colors"),options={chart:{height:320,type:"radialBar"},plotOptions:{radialBar:{hollow:{size:"70%"},track:{background:"rgba(170,184,197, 0.2)"}}},colors:colors=dataColors?dataColors.split(","):colors,series:[70],labels:["CRICKET"]},chart=new ApexCharts(document.querySelector("#basic-radialbar"),options),colors=(chart.render(),["#6c757d","#ffbc00","#ce7e7e","#6ac75a"]),dataColors=$("#multiple-radialbar").data("colors"),options={chart:{height:320,type:"radialBar"},plotOptions:{circle:{dataLabels:{showOn:"hover"}},radialBar:{track:{margin:20,background:"rgba(170,184,197, 0.2)"},hollow:{size:"5%"},dataLabels:{name:{show:!1},value:{show:!1}}}},stroke:{lineCap:"round"},colors:colors=dataColors?dataColors.split(","):colors,series:[44,55,67],labels:["Apples","Oranges","Bananas","Berries"],responsive:[{breakpoint:380,options:{chart:{height:260}}}]},colors=((chart=new ApexCharts(document.querySelector("#multiple-radialbar"),options)).render(),["#6ac75a","#ce7e7e"]),dataColors=$("#circle-angle-radial").data("colors"),options={chart:{height:380,type:"radialBar"},plotOptions:{radialBar:{offsetY:-30,startAngle:0,endAngle:270,hollow:{margin:5,size:"30%",background:"transparent",image:void 0},track:{background:"rgba(170,184,197, 0.2)"},dataLabels:{name:{show:!1},value:{show:!1}}}},colors:colors=dataColors?dataColors.split(","):colors,series:[76,67,61,90],labels:["Vimeo","Messenger","Facebook","LinkedIn"],legend:{show:!0,floating:!0,fontSize:"13px",position:"left",offsetX:10,offsetY:10,labels:{useSeriesColors:!0},markers:{size:0},formatter:function(a,o){return a+":  "+o.w.globals.series[o.seriesIndex]},itemMargin:{horizontal:1}},responsive:[{breakpoint:480,options:{legend:{show:!1}}}]},options=((chart=new ApexCharts(document.querySelector("#circle-angle-radial"),options)).render(),{chart:{height:360,type:"radialBar"},fill:{type:"image",image:{src:["assets/images/small/small-2.jpg"]}},plotOptions:{radialBar:{hollow:{size:"70%"}}},series:[70],stroke:{lineCap:"round"},labels:["Volatility"],responsive:[{breakpoint:380,options:{chart:{height:280}}}]}),colors=((chart=new ApexCharts(document.querySelector("#image-radial"),options)).render(),["#ce7e7e"]),dataColors=$("#stroked-guage-radial").data("colors"),options={chart:{height:380,type:"radialBar"},plotOptions:{radialBar:{startAngle:-135,endAngle:135,dataLabels:{name:{fontSize:"16px",color:void 0,offsetY:120},value:{offsetY:76,fontSize:"22px",color:void 0,formatter:function(a){return a+"%"}}},track:{background:"rgba(170,184,197, 0.2)",margin:0}}},fill:{gradient:{enabled:!0,shade:"dark",shadeIntensity:.2,inverseColors:!1,opacityFrom:1,opacityTo:1,stops:[0,50,65,91]}},stroke:{dashArray:4},colors:colors=dataColors?dataColors.split(","):colors,series:[67],labels:["Median Ratio"],responsive:[{breakpoint:380,options:{chart:{height:280}}}]},colors=((chart=new ApexCharts(document.querySelector("#stroked-guage-radial"),options)).render(),["#8f75da","#ce7e7e"]),dataColors=$("#gradient-chart").data("colors"),options={chart:{height:330,type:"radialBar",toolbar:{show:!0}},plotOptions:{radialBar:{startAngle:-135,endAngle:225,hollow:{margin:0,size:"70%",background:"transparent",image:void 0,imageOffsetX:0,imageOffsetY:0,position:"front",dropShadow:{enabled:!0,top:3,left:0,blur:4,opacity:.24}},track:{background:"rgba(170,184,197, 0.2)",strokeWidth:"67%",margin:0},dataLabels:{showOn:"always",name:{offsetY:-10,show:!0,color:"#888",fontSize:"17px"},value:{formatter:function(a){return parseInt(a)},color:"#111",fontSize:"36px",show:!0}}}},fill:{type:"gradient",gradient:{shade:"dark",type:"horizontal",shadeIntensity:.5,gradientToColors:colors=dataColors?dataColors.split(","):colors,inverseColors:!0,opacityFrom:1,opacityTo:1,stops:[0,100]}},series:[75],stroke:{lineCap:"round"},labels:["Percent"]},colors=((chart=new ApexCharts(document.querySelector("#gradient-chart"),options)).render(),["#8f75da","#ce7e7e"]),dataColors=$("#gradient-chart").data("colors"),options={series:[76],chart:{type:"radialBar",offsetY:-20,sparkline:{enabled:!0}},plotOptions:{radialBar:{startAngle:-90,endAngle:90,track:{background:"rgba(170,184,197, 0.2)",strokeWidth:"97%",margin:5,dropShadow:{top:2,left:0,color:"#eef2f7",opacity:1,blur:2}},dataLabels:{name:{show:!1},value:{offsetY:-2,fontSize:"22px"}}}},grid:{padding:{top:-10}},colors:colors=dataColors?dataColors.split(","):colors,labels:["Average Results"]};(chart=new ApexCharts(document.querySelector("#semi-circle-gauge"),options)).render();