$(document).ready(function(){
  // google.charts.load('current', {packages: ['corechart', 'line']});
  // google.charts.setOnLoadCallback(drawChart);
  drawTable();
  changeActive();
  $("#print-sales").on('click', function(){
    window.print();
  });
});
filter = 0;

function drawTable(){
  $('#table-body').empty();
  $("#filter-disp").html($('.active-selection').html());
  $.post('../../php/handlers/transactionHandler.php', {'init-table': 0, 'filter-chart' : filter},function(data){

    jsondata = JSON.parse(data);
    jsondata.forEach(value =>{
      $('#table-body').append(`
        <tr>
          <th scope="row">`+value.id+`</th>
          <td>`+value.date+`</td>
          <td>`+value.guest_name+`</td>
          <td>`+value.price_paid+`</td>
        </tr>
      `);
    });
  });
}
function drawChart() {
    $.post('../../php/handlers/transactionHandler.php', {'init-chart': 0, 'filter-chart' : filter},function(data){
      jsondata = JSON.parse(data);
      dataArray = [['Month', 'Sales'], ['No Data', 0]];
      if(jsondata.length > 0){
        dataArray.pop();
      }
      jsondata.forEach(value => {
        temp = [];
        if(filter == 0 ){
          temp.push(value.month + ' ' + value.day + ',\n' +value.year);
        }else if(filter == 1){
          temp.push('Week '+value.week);
        }else if(filter == 2){
          temp.push(value.month + ',\n' + value.year);
        }
        temp.push(parseInt(value.total_paid));
        dataArray.push(temp);
      });
      console.log(dataArray);
      var table = google.visualization.arrayToDataTable(dataArray);
      var options = {
          title: 'Monthly Sales Report'
          // curveType: 'function'
        };
      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
      chart.draw(table, options);
    });
  }
function changeActive(){
  $(".selection").click(function(){
    $(".selection").removeClass('active-selection');
    $(this).addClass('active-selection');
    filter = $(this).attr('attrid');
    // drawChart();
   drawTable();

  });
}


