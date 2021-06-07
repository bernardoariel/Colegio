/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if(localStorage.getItem("capturarRangoColorado") != null){

	$("#daterange-btn-colorado span").html(localStorage.getItem("capturarRangoColorado"));


}else{

	$("#daterange-btn-colorado span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}
$('#daterange-btn-colorado').daterangepicker(
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
    $('#daterange-btn-colorado span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

    var fechaInicial = start.format('YYYY-MM-DD');
    console.log("fechaInicial", fechaInicial);

    var fechaFinal = end.format('YYYY-MM-DD');
    console.log("fechaFinal", fechaFinal);

    var capturarRangoColorado = $("#daterange-btn-colorado span").html();
   
   	localStorage.setItem("capturarRangoColorado", capturarRangoColorado);

   	window.location = "index.php?ruta=colorado&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

  }

)