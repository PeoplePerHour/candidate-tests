angular.module('PeoplePerHour').controller('CharactersController', function(getRequest, $scope, $location, $routeParams, ngDialog, $timeout, $q, $window) {

    // initialize vairiables and data
    $scope.initiaze = function(){

      $scope.hideLoader = false;

      $scope.thead = ['id', 'image', 'name', 'status', 'species', 'type', 'gender', 'origin', 'location', 'created']; // , 'episode', 'url'

      $scope.genders = ['female', 'male', 'genderless', 'unknown'];
      $scope.species = ['Human', 'Humanoid', 'Alien', 'Poopybutthole', 'Mytholog', 'Vampire', 'Cronenberg', 'Disease', 'Robot', 'Animal', 'Poopybutthole', 'unknown'];
      $scope.status = ['alive', 'dead', 'unknown'];

      $scope.page = Number($routeParams.page) || 1;
      $scope.selectedgender = $routeParams.selectedgender;
      $scope.selectedspecies = $routeParams.selectedspecies;
      $scope.selectedstatus = $routeParams.selectedstatus;

      $scope.error = false;
      $scope.singlecharacter = {};

      $scope.limit = columnLimit($window.innerWidth);

      $scope.getCharacters($scope.page, $scope.selectedgender, $scope.selectedspecies, $scope.selectedstatus);

    }

    // on window resize find appropriate columns length
    angular.element($window).bind('resize', function(){
      $scope.$apply(function() {
          $scope.width = $window.innerWidth;
          $scope.height = $window.innerHeight;
          $scope.limit = columnLimit($window.innerWidth);
      });
    });

    // get characters data, retry if some error occured and stop loading
    var retriesCount = 0;
    $scope.getCharacters = function(page,gender,species,status){
      getRequest.characters(page,gender,species,status)
      .then(
        function(response) {
          if (response.error){
            $scope.error = response.data.error;
            $timeout(function(){
              $scope.hideLoader = true;
            })
            return false;
          } else {
            $scope.characters = response.data.results;
            $scope.pages = response.data.info.pages;
            $scope.error = false;
            $timeout(function(){
              $scope.hideLoader = true;
            })
            return true;
          }
        },
        function(reason) {
          if(retriesCount++ < 2){
            // some error, try to recover once again
            return $scope.getCharacters($scope.page, $scope.selectedgender, $scope.selectedspecies, $scope.selectedstatus);
          } else {
            // finally reject
            $scope.error = reason.data.error || 'Some error occured.';
            $timeout(function(){
              $scope.hideLoader = true;
            })
            return $q.reject(reason);
          }
        }
      )
    }

    // routing function builds link base on config.js
    $scope.select = function(page,gender,species,status) {
      gender = (gender) ? '/gender/'+gender : '';
      species = (species) ? '/species/'+species : '';
      status = (status) ? '/status/'+status : '';
      page = (page>1) ? '/page/'+page : '';
      $location.path('/characters'+gender+species+status+page)
    }

    // get character data and show modal
    $scope.showCharacter = function(character){
      $scope.singlecharacter = {};
      character.newepisode = [];
      var numbers = []
      angular.forEach(character.episode, function(url,index){
        numbers.push(url.match(/\d+/g).map(Number));
      })
      numbers.join(',');
      // console.log(numbers.join(','));
      if (character.episode.length){
        getRequest.episode(numbers).then( function(response){
          // check success-status of returned data
          if(response.status==200){
            character.newepisode = character.episode.length>1 ? response.data : [response.data];
            $timeout(function(){
              $scope.singlecharacter = character;
              $scope.openModal()
            })
            return true;
          } else {
            // reject with error
            return $q.reject('some error occured');
          }
        })
      } else {
        $timeout(function(){
          $scope.singlecharacter = character;
          $scope.openModal()
        })
      }
    }

    // open modal
    $scope.openModal = function(){
      ngDialog.open({
        templateUrl: 'templates/character.html',
        className: 'ngdialog-theme-default dialog-center',
        scope: $scope
      })
    }

    // reduce column limit given the window width
    function columnLimit(width) {
      var limit = $scope.thead.length;
      if (width<520) {
        limit-=5;
      } else if (width<700) {
        limit-=4;
      } else if (width<780) {
        limit-=3;
      } else if (width<850) {
        limit-=2;
      }  else if (width<940) {
        limit--;
      }
      return limit;
    }

});
