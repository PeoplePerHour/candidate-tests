angular.module('PeoplePerHour').factory('getRequest', function($http) {

    var getRequest = {};

    var character = 'https://cors-anywhere.herokuapp.com/https://rickandmortyapi.com/api/character/';
    var episode = 'https://cors-anywhere.herokuapp.com/https://rickandmortyapi.com/api/episode/';

    // characters listing RESTfull API call with filters and paging
    getRequest.characters = function(page=1,gender,species,status){
        page = '?page='+page;
        gender = (gender) ? '&gender='+gender : '';
        species = (species) ? '&species='+species : '';
        status = (status) ? '&status='+status : '';
        url = character+page+gender+species+status;
        return $http.get(url);
    };

    // single character information RESTfull API call
    getRequest.episode = function(numbers){
        url = episode+numbers;
        return $http.get(url);
    };

    return getRequest;

});
