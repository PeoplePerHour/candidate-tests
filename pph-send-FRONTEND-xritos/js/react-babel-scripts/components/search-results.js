
class Results extends React.Component {

  	constructor(props) 
	{
		super();
		this.state = {};
	}
	
	render() 
	{ 			
		return (
				<div class="search-results">
					<div class="results-header"><h2 class="title">Characters</h2></div>
					<div class="results-body">
					{ 	
						this.props.results.map( 
														(x,k) => {	
																	assert.isObject(x, 'each item of results in response must be object');
																	assert.property( x, 'name', 'name property must exist in every item of results' );
																	
																	return <Character  index={k} charName={x.name} charProfile={x} />																		
																} 
						)
					}
					</div>
				</div>	
		);		
	}
  
}

class Character extends React.Component {

  showCharProfile = (profile) => {
  		
		assert.containsAllKeys( profile , ["created", "episode", "gender", "id", "image", "location", "name", "origin", "species", "status", "type", "url"],"required propries missing");
		
		
		ReactDOM.render(
			<CharacterDetails profile={profile} display={'none'}/>,
			document.getElementById('modal')
		); 
  };
  
  render() {
    return <div><span></span> <h1 class="search-item"	onClick={ (e)=>{this.showCharProfile(this.props.charProfile) } }>{this.props.charName}</h1></div> ;
  }
  
}