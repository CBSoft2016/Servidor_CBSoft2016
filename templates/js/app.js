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
        anchor();
               
    });
   
cbsof_projeto.controller('ScrollController', ['$scope', '$location', '$anchorScroll',
  function ($scope, $location, $anchorScroll) {
    $scope.gotoBottom = function() {
      // set the location.hash to the id of
      // the element you wish to scroll to.
      $location.hash('bottom');

      // call $anchorScroll()
      $anchorScroll();
    };
  }]);
     
    
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
            anchor();
         
            
        })
     }
      
    )
     
}
    atualizalista();
    anchor();


});
cbsof_projeto.service('anchorSmoothScroll', function(){
    this.scrollTo = function(eID) {

        // This scrolling function 
        // is from http://www.itnewb.com/tutorial/Creating-the-Smooth-Scroll-Effect-with-JavaScript
        
        var startY = currentYPosition();
        var stopY = elmYPosition(eID);
        var distance = stopY > startY ? stopY - startY : startY - stopY;
        if (distance < 100) {
            scrollTo(0, stopY); return;
        }
        var speed = Math.round(distance / 100);
        if (speed >= 20) speed = 20;
        var step = Math.round(distance / 25);
        var leapY = stopY > startY ? startY + step : startY - step;
        var timer = 0;
        if (stopY > startY) {
            for ( var i=startY; i<stopY; i+=step ) {
                setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
                leapY += step; if (leapY > stopY) leapY = stopY; timer++;
            } return;
        }
        for ( var i=startY; i>stopY; i-=step ) {
            setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
            leapY -= step; if (leapY < stopY) leapY = stopY; timer++;
        }
        
        function currentYPosition() {
            // Firefox, Chrome, Opera, Safari
            if (self.pageYOffset) return self.pageYOffset;
            // Internet Explorer 6 - standards mode
            if (document.documentElement && document.documentElement.scrollTop)
                return document.documentElement.scrollTop;
            // Internet Explorer 6, 7 and 8
            if (document.body.scrollTop) return document.body.scrollTop;
            return 0;
        }
        
        function elmYPosition(eID) {
            var elm = document.getElementById(eID);
            var y = elm.offsetTop;
            var node = elm;
            while (node.offsetParent && node.offsetParent != document.body) {
                node = node.offsetParent;
                y += node.offsetTop;
            } return y;
        }

    };
    
});
cbsof_projeto.controller('ScrollCtrl', function($scope, $location, anchorSmoothScroll) {
    
    $scope.gotoElement = function (eID){
      // set the location.hash to the id of
      // the element you wish to scroll to.
      $location.hash('bottom');
 
      // call $anchorScroll()
      anchorSmoothScroll.scrollTo(eID);
      
    };
  });
function anchor(){
    var target_offset = $("#ancora1").offset();
    var target_top = target_offset.top;
    $('html, body').animate({ scrollTop: target_top +"150px" }, 0);
}

        
