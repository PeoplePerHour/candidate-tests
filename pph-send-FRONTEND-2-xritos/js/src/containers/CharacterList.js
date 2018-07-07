class CharacterList extends React.Component {
  constructor(props) {
  	super();
  	this.state = {};
  }
  
  
  render() { 			
    return (
  	  <div class="search-results">
  	    <div class="results-header">
		  <h2 class="title">Characters</h2>
		</div>
  		<div class="results-body">
  		  {this.props.results.map((x,k) => {    
  		    return <Character  
				     index={k} 
					 charName={x.name} 
					 charProfile={x} 
				   />																		
  		  })}
  		</div>
  	  </div>	
  	);		
  } 
}