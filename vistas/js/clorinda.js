/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRangoClorinda") != null){

	$("#daterange-btn-clorinda span").html(localStorage.getItem("capturarRangoColorado"));


}else{

	$("#daterange-btn-clorinda span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}
$('#daterange-btn-clorinda').daterangepicker(
  {
    ranges   : {
      'Hoy'       : [moment(), moment()],
      'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
      'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
      'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment(),
    endDate  : moment()
  },
  function (start, end) {
    $('#daterange-btn-clorinda span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');
    console.log("fechaInicial", fechaInicial);

    var fechaFinal = end.format('YYYY-MM-DD');
    console.log("fechaFinal", fechaFinal);

    var capturarRangoClorinda = $("#daterange-btn-clorinda span").html();
   
   	localStorage.setItem("capturarRangoClorinda", capturarRangoClorinda);

   	window.location = "index.php?ruta=clorinda&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)