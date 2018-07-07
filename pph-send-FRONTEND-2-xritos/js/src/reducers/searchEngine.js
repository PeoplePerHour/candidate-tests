/**
 *		Init redux store
 */
const initialState = {
  searched: {
    results: [],
	filters: {
	  page: 0,
	  gender: '',
	  status: '',
	  species: ''
	},
	url: '',			
	/**	
	 *	initial values for normalised JSON response.
	 *		
	 *  genders,species,statuses,types,episodes,locations 
	 *  will grow after each request based on unique elements found on each response.
	 */					
	normalisedJSON: {
	  genders: [],
	  species: [],
	  statuses:	[],
	  types: [],				
	  episodes:	[],
	  locations: [],	  
	  geo: {},	/*temporary to help with locations */			
	  characters: []				
	},	
	prevURL: '',
	nextURL: '',
	totalPages: '',			
  }
};


function searchEngine(state = initialState , action) {
  if (typeof state === 'undefined') {
    return initialState;
  }
  switch (action.type) {
  
    case 'DO_SEARCH' : 
			
	  const s = serializeObj(state.searched.filters);				
	  const URL = 'https://rickandmortyapi.com/api/character/' + s ;	
		
	  axios.get( URL )
	  .then(function (response) {
		  
		let data = response.data;	
		state.searched.prevURL = data.info.prev; 
		state.searched.nextURL = data.info.next;
		state.searched.totalPages = data.info.pages;
		state.searched.results	= data.results;
							
		ReactDOM.render(
		  <CharacterList 
			results={data.results}
		  />,
		  document.getElementById('results')
		);		
		
		if (action.pushHistory && action.pushHistory === true) {
		  saveHistory( state.searched.filters , s );
		}								
		/** Prints in console Normalised Response **/
		jsonNormalizer(data.results,state.searched.normalisedJSON);								
	  })
	  .catch(function (error) {
	    console.log("error",error);
	  });	
	  return state;	
	case 'UPDATE_FILTER': 
	  if (action.prop != 'page') {
	    state.searched.filters.page = 0;
	  }
	  state.searched.filters[action.prop] = action.val ;
	  return state;	
	case 'UPDATE_FILTERS_BY_URL': 	
	  let queryStrings 	= 	getParameterByName() ;
	  state.searched.filters.gender = queryStrings.get("gender") || '';
	  state.searched.filters.status = queryStrings.get("status") || '';
	  state.searched.filters.species = queryStrings.get("species") || '';		
	  state.searched.filters.page = queryStrings.get("page") || 0 ;	
	  return state;
	case 'GO_NEXT': 	
	  if (state.searched.nextURL) { 		 
	    state.searched.filters.page = state.searched.nextURL.match(/page=([\d]+)/)[1];
	  } else {
	    state.searched.filters.page =(state.searched.totalPages? Math.min( state.searched.filters.page + 1 ,state.searched.totalPages) 	: parseInt(state.searched.filters.page+1,10) );
	  }
	  return state;		
	case 'GO_BACK': 	
	  if (state.searched.prevURL) {  
	    state.searched.filters.page = state.searched.prevURL.match(/page=([\d]+)/)[1]; 
	  } else {
	    state.searched.filters.page = Math.max( state.searched.filters.page - 1 , 0); 
	  }		
	  return state;		
	case 'NORMALIZE_RESPONSE': 			
	  jsonNormalizer(state.searched.results,state.searched.normalisedJSON);
	  return state;		
	default: 
	  return state;
  }
  return state;
}
