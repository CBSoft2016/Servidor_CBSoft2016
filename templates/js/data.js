cbsof_projeto.factory("Data", ['$http',
    function ($http) { // This service connects to our REST API

        

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
            return $http.get(q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http.post(q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);