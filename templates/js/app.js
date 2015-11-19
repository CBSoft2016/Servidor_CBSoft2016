function getUrlParameter(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
 function atualizalista (){
    location.reload();
 }
 function cadastrapergunta (){
     var idpalestra=getUrlParameter("idpalestra");
     var nomeusuario=getUrlParameter("nome");
     var pergunta=$("#perguntatext").val();
     $.post( "cadastrapergunta", { idpalestra: idpalestra, pergunta: pergunta,nomeusuario:nomeusuario })
        .done(function( ) {
    alert( "Pergunta enviada com sucesso ");
    });
  

 }
 
 cbsof_projeto.controller('getperguntas', function ($scope, $rootScope, $window, $http,Data){
    $scope.perguntas;
    var idpalestra=getUrlParameter("idpalestra");
    Data.get('getperguntas/'+idpalestra).then(function(data){
        $scope.perguntas = data.data;
    });
    
    
});
         
          
