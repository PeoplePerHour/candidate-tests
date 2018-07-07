class Character extends React.Component {	
  constructor(props) {
    super();
	
	this.showCharProfile = this.showCharProfile.bind(this);
  }
  
  
  showCharProfile(profile) {
	ReactDOM.render(
	  <CharacterDetails 
	    profile={profile} 
		display={'none'}
	  />,
	  document.getElementById('modal')
	); 
  };
  
  
  render() {
    return (
	  <div>
		<span></span>
		<h1 class="search-item"
		  onClick={(e)=>{this.showCharProfile(this.props.charProfile)}}
		>{this.props.charName}</h1>
	  </div>
	);
  } 
}