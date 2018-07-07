
 /**
  *  Create store
  */

const store = Redux.createStore(searchEngine);


 /**
  *	 Connect react components
  */
 
const ConnFilters = ReactRedux.connect(state => state)
      (Filters);
	  
const ConnResults = ReactRedux.connect(state => state)
      (CharacterList);	  
	  
const ConnProfile = ReactRedux.connect(state => state)
      (CharacterDetails);
	  
 /**
  *  Subscribe to render CharacterList
  */
 
function renderResults() {
  let currentState = store.getState();
  ReactDOM.render(
    <CharacterList 
	  results={currentState.searched.results}
	/>,
	document.getElementById('results')
  );	
  console.log("results updated");
} 

store.subscribe(renderResults);



ReactDOM.render(
  (
    <ReactRedux.Provider store={store}>
      <ConnFilters />
    </ReactRedux.Provider>
  ),
  document.getElementById('root')
);