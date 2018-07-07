

class CharacterDetails extends React.Component {

  constructor(props) 
  {
		super();
		this.state = {
			loaded  : false,
			display : 'none'
		};
  }
  
  componentDidUpdate(prevProps) {
		this.state.display	= "none";
		this.state.loaded	= false;
  }

  showIt = () => { 
		this.setState({loaded:true,display:'block'});
  }
  
  
  render() {

		return (
				<div class="custom-modal"	style={{display:this.state.display}} onClick={()=>{this.setState({display:'none'})}}>
					<div class="modal-body" >
						<div class="closer"><a href="#" onClick={()=>{this.setState({display:'none'})}}>Close</a></div>
						<div class="portait"><Image 	sourceZ	={this.props.profile.image} showProfile={this.showIt} />	</div>
						<div class="primary-properties">
							<div><h2>name</h2>		<h3>{this.props.profile.name	||'not defined'}	</h3></div>					
							<div><h2>gender</h2>	<h3>{this.props.profile.gender	||'not defined'}	</h3></div>		
							<div><h2>status</h2>	<h3>{this.props.profile.status	||'not defined'}	</h3></div>
							<div><h2>species</h2>	<h3>{this.props.profile.species	||'not defined'}	</h3></div>
							<div><h2>type</h2>		<h3>{this.props.profile.type	||'not defined'}	</h3></div>
							<div><h2>created:</h2>	<h3>{this.props.profile.created	||'not defined'}	</h3></div>
						</div>	
						<div class="secondary-properties">			
							<Episodes 	episodes={this.props.profile.episode} 	/>
							<Location 	location={this.props.profile.location} 	/>
							<Origin		origin	={this.props.profile.origin} 	/>					
							<h1 class="details"><a  href={this.props.profile.url}>Details</a></h1>
						</div>
					</div>
				</div>			
		);
  }
}

class Image extends React.Component {

	constructor(props) 
	{
		super();
		this.state = { srcZ: null, img: 'inline-block', fallback: 'none' };
	}
	
	la= () => {this.setState({ img: 'none', fallback: 'inline-block' });	console.log("error loading image");this.props.showProfile();}
	
	loadImageSource = () => {

			const addImageProcess = (src) => { 
				return new Promise((resolve, reject) => { 
							let img = new Image();
							img.onload  = resolve(img);
							img.onerror = reject(img);
							img.src = src;	
				})	
			}
		
			addImageProcess(this.props.sourceZ).then(
				(u) => {
							this.setState({ srcZ: this.props.sourceZ, img: 'inline-block', fallback: 'none' });
				},
				(err) => {	console.log("rejected: ", err)
							this.setState({ srcZ: this.props.sourceZ, img: 'none', fallback: 'inline-block' });
				}
			);	
	}
	
	componentDidMount()
	{
		this.loadImageSource();
	}
	
	componentDidUpdate(prevProps) {
	
		if(prevProps.sourceZ && prevProps.sourceZ===this.props.sourceZ){return;}
		
		this.loadImageSource();
	}
  
  
	render() {
		return (<div style={{display:'inline-block'}}>
					<img  style={{display:this.state.img}} src={this.state.srcZ} onLoad={this.props.showProfile} onError={this.la} />
					<span style={{width:'200px',display:this.state.fallback}}>NO IMAGE SRC</span>
				</div>
		);
	}
  
}


class Episodes extends React.Component {

	render() 
	{ 
		return (
				<div class="episodes">
					<h3    style={{padding: "0px"}}>Episodes</h3>
					{ 	
						this.props.episodes.map( 
														(x) => 	{
																	return <Episode  episodeName={x} />																	
																} 
						)
					}
				</div>	
		);		
	}
  
}
class Episode extends React.Component {

	regNo = (v) => {
	
		return  v.match(/\d+$/);
	}
	
	render() {
  
		return <h3 class="episode">{this.regNo(this.props.episodeName)}</h3>;
	
	} 
}



class Location extends React.Component {

  render() {
  
		return( 
				<div class="location">
					<span class="title" >Location : </span>
					<a href={this.props.location.url}>{this.props.location.name}</a>
				</div>	
		);
  }
  
}

class Origin extends React.Component {

  render() {
  
		return( 
				<div class="origin">
					<span class="title" >Origin : </span>
					<a href={this.props.origin.url}>{this.props.origin.name}</a>
				</div>	
		);
  }
}
