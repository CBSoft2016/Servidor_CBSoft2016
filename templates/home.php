<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="cbsof_projeto">
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="templates/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="templates/css/index.css">
        <link rel="stylesheet" type="text/css" href="templates/css/style.css">
        <link rel="stylesheet" type="text/css" href="templates/css/font-awesome.css">
        
        <script src="templates/js/jquery.js"></script>
        <script src="templates/js/angular.min.js"></script>
        <script src="templates/js/angular-route.min.js"></script>
         <script src="templates/js/angular-resource.min.js"></script>
        <script src="templates/js/cbsof_projeto.js"></script>
        
        
        <script src="templates/js/data.js"></script>
        
        <script src="templates/js/app.js"></script>
    </head>
    <body>
        <div class="container-fluid nopadding"  ng-controller="getperguntas">
            <div class="topo">
                <div class="container">
                  
                </div>
            </div>
            
            
             <div class="container" ng-controller="getperguntas">
        <div class="row pad-top pad-bottom">
            <div class=" col-lg-12 col-md-12 col-sm-12">
                <div class="chat-box-div">
                    <div class="chat-box-head">
                        CBsoft2016 
                            
                    </div>
                    <div class="panel-body chat-box-main" ng-repeat="c in perguntas">
                        <div class="chat-box-left">
                            {{c.pergunta}}
                        </div>
                        <div class="chat-box-name-left">
                            - {{c.nomeusuario}}
                        </div>
                        <hr class="hr-clas" />
                       
                    </div>
                    

                </div>
                <div class="chat-box-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" id="perguntatext" placeholder="Digite sua pergunta aqui">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button" onclick="cadastrapergunta()">Enviar</button>
                            </span>
           
                        </div>
                        <div class="input-group col-lg-12 col-md-12 col-sm-12" style="margin-top: 20px;">
   
                            <span class="input-group-btn">
                                <button class="btn btn-success  col-lg-12 col-md-12 col-sm-12" type="button" onclick="atualizalista()">Atualizar lista</button>
                            </span>
                        </div>
                    </div>

            </div>
        </div>
            </div>
    </div>
        <script>
          var idpalestra=getUrlParameter("idpalestra");
          var nomeusuario=getUrlParameter("nome");
        </script>
          
    </body>
</html>

