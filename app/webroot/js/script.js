$(document).ready(function(){
  
    var jsonurl = $(location).attr('href').split("/Arena")[0]+"/Arena/halloffeme";
    
    var ret = null;
    var arr = [];
    var result = [];
    var tab = new Array();
        var tabbb = new Array();
   
    
 var tabGuild = new Object();
    var tabGuildA=new Array;
    
    $.ajax({
        async: false,
        url: jsonurl,
        datatype : "json",
        success: function(data) {
           ret = JSON.parse(data); 
                     
            for(var i=0;i<ret.length; i++){
                 tabGuild = new Array(ret[i]["Player"].email, ret[i][0].nb); 
                 tabGuildA[i] = tabGuild;
             }                
            result = Object.keys(tabGuildA).map(function (key) {return tabGuildA[key];});
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("erreur 1");
                alert(thrownError);
        }
    });
    
    var plot1 = jQuery.jqplot ('chart1', [result], { 
            
            title: 'Pourcentage de personnages utilisés par joueur',
            seriesDefaults: {
            // Make this a pie chart.
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: {
                  // Put data labels on the pie slices.
                  // By default, labels show the percentage of the slice.
                  showDataLabels: true
                }
            }, 
            legend: { show:true, location: 'e' }
        });
       
/*****************************************************************************************************/

    var jsonurlfighter = "./halloffemefighter";
    var tabFighter = new Object();
    var tabFighterA=new Array;
    
    $.ajax({
        async: false,
        url: jsonurlfighter,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data);            
             
            for(var i=0;i<ret.length; i++){
                 tabFighter = new Array("Niveau "+ret[i]["Fighter"].niveau, ret[i][0].nb); 
                 tabFighterA[i] = tabFighter;
             }
                
            result = Object.keys(tabFighterA).map(function (key) {return tabFighterA[key];});
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("1");
                alert(thrownError);
        }
    });

    var plot2 = $.jqplot('chart2', [result], {
      title: 'Nombre de fighter par Niveau',
      series:[{renderer:$.jqplot.BarRenderer}],
      axesDefaults: {
          tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
          tickOptions: {
            fontFamily: 'Georgia',
            fontSize: '10pt',
            angle: -30
          }
      },
      axes: {
        xaxis: {
          renderer: $.jqplot.CategoryAxisRenderer
          
         // tickInterval: '1', //intervalle d'affichage par defaut
          //  min: '0',
            //max: '10',
        },
        yaxis: {
         tickInterval: '1', //intervalle d'affichage par defaut
            min: '0',
            max: '10'
      }
      }
    });


/*****************************************************************************************************/

    var jsonurldate = "./halloffemedate";
    var tabdate = new Object();
    var tabdateA=new Array;
    
    $.ajax({
        async: false,
        url: jsonurldate,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data);            
             console.log(ret);
            for(var i=0;i<ret.length; i++){
                tabdate = new Array(ret[i]["Events"].date, ret[i][0].nb); 
                 tabdateA[i] = tabdate;
             }
                
            result = Object.keys(tabdateA).map(function (key) {return tabdateA[key];});
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("2");
                alert(thrownError);
        }
    });
    
    
    var plot3 = $.jqplot('chart3', [result], {
    title:'Nombre d évènements par jour',
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            tickOptions:{formatString:'%b %#d, %#I'},
            tickInterval:'2 weeks'
        }
    },
    series:[{lineWidth:4, markerOptions:{style:'square'}}]
  });
  
  
  /*****************************************************************************************************/

    var jsonurlsight = "./halloffemesight";
    var jsonurlstrength = "./halloffemestrength";
    var jsonurlhealth = "./halloffemehealth";
    var jsonurlcurrenthealth = "./halloffemecurrenthealth";
    var jsonurlname = "./halloffemename";
    var resultsight = [];
    var resultstrength = [];
    var resulthealth = [];
    var resultcurrenthealth = [];
    var ticks = [];
    
    var arr = [];

    $.ajax({
        async: false,
        url: jsonurlsight,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data); 
               
            //object to array
           for (var x in ret){
                arr.push(ret[x]);
            }
                 
            //recupérer seulement les nombres      
            for(var i=0;i<arr.length; i++){
                tab[i] = arr[i]["Fighter"].skill_sight;
            } 
                
                
            resultsight = tab.map(function (x){
                return parseInt(x, 10);
            });          
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("3");
                alert(thrownError);
        }
    });
     console.log(resultsight);
    
    
    var arr = [];
    $.ajax({
        async: false,
        url: jsonurlstrength,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data); 
            
            //object to array
           for (var x in ret){
                arr.push(ret[x]);
            }
                  console.log("arrrrrrrr"+arr);
            //recupérer seulement les nombres      
            for(var i=0;i<arr.length; i++){
                tab[i] = arr[i]["Fighter"].skill_strength;
            } 
                              console.log("tabbbbbbbbbbb"+tab);

                
                
            resultstrength = tab.map(function (x){
                return parseInt(x, 10);
            });          
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("4");
                alert(thrownError);
        }
    });
    
    var arr = [];
    console.log(resultstrength);
    $.ajax({
        async: false,
        url: jsonurlhealth,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data); 
           
            //object to array
           for (var x in ret){
                arr.push(ret[x]);
            }
                 
            //recupérer seulement les nombres      
            for(var i=0;i<arr.length; i++){
                tab[i] = arr[i]["Fighter"].skill_health;
            } 
                
                
            resulthealth = tab.map(function (x){
                return parseInt(x, 10);
            });          
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("testt");
                alert(thrownError);
        }
    });
  console.log(resulthealth);

    var arr = [];
    $.ajax({
        async: false,
        url: jsonurlcurrenthealth,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data); 
           
            //object to array
           for (var x in ret){
                arr.push(ret[x]);
            }
                 
            //recupérer seulement les nombres      
            for(var i=0;i<arr.length; i++){
                tab[i] = arr[i]["Fighter"].current_health;
            } 
                
                
            resultcurrenthealth = tab.map(function (x){
                return parseInt(x, 10);
            });          
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("5");
                alert(thrownError);
        }
    });

  console.log(resultcurrenthealth);

    var arr = [];
    $.ajax({
        async: false,
        url: jsonurlname,
        datatype : "json",
        success: function(data) {
            ret = JSON.parse(data); 
           console.log(ret);
            //object to array
           for (var x in ret){
                arr.push(ret[x]);
            }
            console.log(arr);
                 
            //recupérer seulement les nombres      
            for(var i=0;i<arr.length; i++){
                ticks[i] = arr[i]["Fighter"].name;
            } 
                    
        },
        error:function (xhr, ajaxOptions, thrownError) {
                alert("6");
                alert(thrownError);
        }
    });
    
       
    plot4 = $.jqplot('chart4',[resultsight, resultstrength, resulthealth, resultcurrenthealth],{
       title: 'Les 5 premiers personnages crées',
       legend: {
           show: true
       },
       seriesDefaults: {
           renderer: $.jqplot.BarRenderer,
           rendererOptions: {
               barPadding: 2
           }
       },
       series: [
          {label: 'Sight'},
          {label: 'Strength'},
          {label: 'Health'},
          {label: 'Current health'}
       ],
       axes: {
           xaxis: {
               label: 'Les Personnages',
               renderer: $.jqplot.CategoryAxisRenderer,
               tickRenderer: $.jqplot.CanvasAxisTickRenderer,
               labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
               ticks: ticks,
               tickOptions: {
                   angle: -30
                }
           },
           yaxis: {
               tickRenderer: $.jqplot.CanvasAxisTickRenderer,
              tickInterval: '1', //intervalle d'affichage par defaut
                 min: '0',
                    max: '10',
               tickOptions: {
                   formatString: '%d',
                   angle: -30
                }
                
                
           }
       }
    });
});