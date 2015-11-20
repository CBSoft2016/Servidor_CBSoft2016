var tempo;
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
            $("#perguntatext").val("");
    });
  

 }
 
 cbsof_projeto.controller('getperguntas', function ($timeout,$scope, $rootScope, $window, $http,Data){

     $scope.perguntas;
    var idpalestra=getUrlParameter("idpalestra");
    Data.get('getperguntas/'+idpalestra).then(function(data){
        $scope.perguntas = data.data;
    });
    
    
//    http://stackoverflow.com/questions/23181616/angular-js-update-json-on-interval-and-update-the-view
function atualizalista(){
    tempo=$timeout(
        function (){
        console.log("execucao do tempo",Date.now()) ;          
        },
        10000
     );
     tempo.then(function (){
      
         console.log("5 segundos");
        $http({
            method:'GET',
            url:"getperguntas/"+idpalestra
        })
        .success(function (data,status,headers,config){
            $scope.perguntas = data.data;
            atualizalista();
            
        })
     }
      
    )
     
}
    atualizalista();

});
        
