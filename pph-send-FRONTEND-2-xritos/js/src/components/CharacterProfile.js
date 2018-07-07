

class CharacterDetails extends React.Component {
  constructor(props) {
    super();
	this.state = {
	  loaded: false,
	  display: 'none'
	};
	
	this.showIt = this.showIt.bind(this);
	this.getEpisodeNumber = this.getEpisodeNumber.bind(this);
  }
 
 
  componentDidUpdate(prevProps) {
    this.state.display = 'none';
	this.state.loaded = false;
  }

  
  showIt() { 
    this.setState({
	  loaded: true, 
	  display: 'block'
	});
  }
  
  
  getEpisodeNumber(v) { 
    return  v.match(/\d+$/);  
  }
 
  render() {
    return (
      <div class="custom-modal"	
	    style={{display:this.state.display}} 
		onClick={()=>{this.setState({display:'none'})}}
	   >
      	<div class="modal-body" >
      	  <div class="closer">
		    <a href="#" 
			  onClick={()=>{this.setState({display:'none'})}}
			>Close</a>
		  </div>
      	  <div class="portait">
		    <Image 	
			  sourceZ={this.props.profile.image} 
			  showProfile={this.showIt} 
			/>
		  </div>
      	  <div class="primary-properties">
      		<div>
			  <h2>name</h2>
			  <h3>{this.props.profile.name || 'not defined'}</h3>
			</div>					
      		<div>
			  <h2>gender</h2>
			  <h3>{this.props.profile.gender || 'not defined'}</h3>
			</div>		
      		<div>
			  <h2>status</h2>
			  <h3>{this.props.profile.status || 'not defined'}</h3>
			</div>
      		<div>
			  <h2>species</h2>
			  <h3>{this.props.profile.species || 'not defined'}</h3>
			</div>
      		<div>
			  <h2>type</h2>
			  <h3>{this.props.profile.type || 'not defined'}</h3>
			</div>
      		<div>
			  <h2>created:</h2>
			  <h3>{this.props.profile.created || 'not defined'}</h3>
			</div>
      	  </div>	
      	  <div class="secondary-properties">			
			<div class="episodes">
			  <h3>Episodes</h3>
			   {this.props.profile.episode.map((x) => {
					return 	<h3 class="episode">{this.getEpisodeNumber(x)}</h3>							
				})
			   }
			</div>			
			<div class="location">
			  <span class="title">Location : </span>
				<a 
				  href={this.props.profile.location.url} 
				>
				  {this.props.profile.location.name}
				</a>
			</div>			
			<div class="origin">
			  <span class="title">Origin : </span>
				<a 
				  href={this.props.profile.origin.url}
				>
				  {this.props.profile.origin.name}
				</a>
			</div>			
      		<h1 class="details">
			  <a  
			    href={this.props.profile.url}
			  >Details</a>
			</h1>
      	  </div>
      	</div>
      </div>			
    );
  }  
}

